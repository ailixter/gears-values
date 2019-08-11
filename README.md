# gears-values
The project that gears values.

1. Value class implements [value, error] pattern.
1. It proposeses simple and clear ValueInterface.
1. It provides protected validation method to override.
1. And simple rules
    - value may only be constructed, not set
    - invalid value cannot be constructed
    - value with errors cannot be returned
    - you can get both if you're willing to

```php
    use Ailixter\Gears\ArrayValue;
    use Ailixter\Gears\Exceptions\ValueException;
    use Ailixter\Gears\ValueInterface;

    class NoEmpties extends ArrayValue
    {
        /**
         * Assures the value not be empty
         * and has no empty items.
         */
        protected function validate()
        {
            $array = $this->getValue();
            if (!$array) {
                $this->addError('array', 'empty');
            } elseif (in_array(null, $array)) {
                $this->addError('array', 'has empty items');
            }
        }
    }

    class Service
    {
        private $data;

        public function __construct(NoEmpties $data)
        {
            $this->data = $data;
        }

        /**
         * This treats long dozen as error too.
         */
        public function run(): NoEmpties
        {
            $key = array_search(13, $this->data->getValue());
            if ($key) {
                $this->data->addError('array', 'has long dozen');
            } else {
                // do something useful
            }
            return $this->data;
        }
    }

    class Client
    {
        private $service;

        public function __construct(Service $service)
        {
            $this->service = $service;
        }

        public function consumeRobustly()
        {
            $this->robust($this->service->run());
        }

        public function consume()
        {
            $this->critical($this->service->run()->get()); // <<= exception here if error
        }

        /**
         * This method checks errors first and if any,
         * provides default behavior.
         */
        private function robust(ValueInterface $data): void
        {
            if ($data->getError()) {
                // no problem, we know how to cope with that
                $array = [1, 2, 1];
            } else {
                $array = $data->getValue();
                $array[] = $array[0];
            }
            $this->process($array);
        }

        /**
         * This method makes no sense with erroneous data,
         * so it shouldn't even be called.
         * @precondition $array is not empty
         */
        private function critical(array $array): void
        {
            $array[] = $array[0];
            $this->process($array);
        }

        /**
         * @precondition $array is not empty
         * @precondition $array has no empty values
         * @precondition $array has no long dozen
         */
        private function process(array $array): void
        {
            echo join(' ', $array);
        }
    }
```
### Acceptable Data
```php
    $client = new Client(new Service([4, 5]));  // ok
    $client->consume();                         // 4 5 4
    $client->consumeRobustly();                 // 4 5 4
```
### Data with Errors
```php
    $client = new Client(new Service([13]))     // ok
    $client->consume();                         // exception - long dozen
    $client->consumeRobustly();                 // 1 2 1 - default behavior
```
### Other Errors
```php
    new Service([]);                            // exception - empty array
    new Service([0]);                           // exception - empty item
    new Service(null);                          // type error
```
