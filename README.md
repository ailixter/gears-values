# gears-values
The project that gears values.

1. Value class implements [value, error] pattern.
1. It proposes simple and clear ValueInterface.
1. It provides protected validation method to override.
1. And simple rules
    - value may only be constructed, not set
    - invalid value cannot be constructed
    - value with errors cannot be returned
    - you can get both if you're willing to

## Basic Usage
```php
    use Ailixter\Gears\IntValue;
    use Ailixter\Gears\ValueInterface;

    class Positive extends IntValue
    {
        protected function validate()
        {
            if ($this->getValue() < 1) {
                $this->addError('value', 'is not positive')
            }
        }
    }

    function calculate(int $int): Positive
    {
        $result = new Positive($int * $int);
        if ($result=>getValue() > 81) {
            $result->addError('value', 'too big');
        }
        return $result;
    }

    function readyForUnexpected(IntValue $int)
    {
        if ($int->getErrors()) {
            $result = 81;
        } else {
            $result = $int->getValue();
        }
        echo $result + 1;
    }

    function wantNoUnexpected(int $int)
    {
        echo $int + 1;
    }

    readyForUnexpected(calculate(8));       // 65
    readyForUnexpected(calculate(10));      // 82

    wantNoUnexpected(calculate(8)->get());  // 65
    wantNoUnexpected(calculate(10)->get()); // exception - too big

    echo calculate(0);                      // exception - not positive
```

