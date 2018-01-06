# Magento Input Validation
Based on [Respect Validation](http://respect.github.io/Validation)

Check full list of [Rules](http://respect.github.io/Validation/docs/validators.html)

# Installation
1. Install by composer  `composer require alaa/magento2-input-validation`
2. Enable the module `php bin/magento module:enable Alaa_RvInputValidation`
3. Magento upgrade `php bin/magento setup:upgrade` 

# Usage
## 1. Backend
This is very simple to use in the backend, you can use the method of your choice that suits the requirement
1. validteInput: this will validate input with a single rule. it accepts two arguments input value as a string and a rule as an array.
2. validate: this will validate input with multiple rules. it loops through rules and call `validateInput` method.
3. validatePostData and validateGetData: this will validate multiple inputs and multiple rules for each input

The array rule elements are:
1. class: required class name such as Email, NotEmpty, Between and etc. This is used to instantiate the validation rule object
2. args: an optional element used to pass into the validation class constructor

Example

```

    // Initialize validation class
    public function __construct(ValidationInterface $validation)
    {
        $this->validation = $validation;
    }
    
    // valid
    $isEmail = $this->validation->validateInput('alaa.almaliki@gmail.com', ['class' => 'Email']);
    $isUrl = $this->validation->validateInput('https://google.com', ['class' => 'Url']);
    $isLegalAge = $this->validation->validateInput('22', ['class' => 'Between', 'args' => ['min' => '18', 'max' => '22']]);
    var_dump($isEmail, $isUrl, $isLegalAge);
    
    
    // invalid
    $isEmail = $this->validation->validateInput('alaa.almaliki@gmail', ['class' => 'Email']);
    $isUrl = $this->validation->validateInput('google.com', ['class' => 'Url']);
    $isLegalAge = $this->validation->validateInput('22', ['class' => 'Between', 'args' => ['min' => '18', 'max' => '20']]);
    var_dump($isEmail, $isUrl, $isLegalAge);
    
    
    // validate method work on multiple rules for each input
    $isEmail = $this->validation->validate('alaa.almaliki@gmail.com', [['class' => 'NotEmpty'], ['class' => 'Email']]);
    var_dump($isEmail);

    $validationResults = $this->validation->validatePostData(
                ['email' => 'alaa.almaliki@gmail.com', 'url' => 'https://google.com'],
                [
                    'email' => [
                        [
                            'class' => 'Email',
                            'success_message' => 'Valid Email',
                            'failure_message' => 'Not Valid Email',
                        ],
                    ],
                    'url' => [
                        [
                            'class' => 'Url',
                            'success_message' => 'Valid Url',
                            'failure_message' => 'Not Valid Url',
                        ]
                    ]
                ]
            );
    
            // results = [
            //      'email' => ['is_valid' => true|false, 'message' => 'Valid Email'|'Not Valid Email'],
            //      'url' => ['is_valid' => true|false, 'message' => 'Valid Url'|'Not Valid Url']
            // ]
            var_dump($validationResults);
    
    // this is an alias of validate post method
    // just to show that you can use multiple rules here for one input
    $emailGetResults = $this->validation->validateGetData(
        ['email' => 'alaa.almaliki@gmail.com'],
        [
            'email' => [
                [
                    'class' => 'NotEmpty',
                    'success_message' => 'Valid Email',
                    'failure_message' => 'Not Valid Email',
                ],
                [
                    'class' => 'Email',
                    'success_message' => 'Valid Email',
                    'failure_message' => 'Not Valid Email',
                ],
            ],
        ]
    );
    
    // results = ['is_valid' => true|false, 'message' => 'Valid Email'|'Not Valid Email']
    var_dump($emailGetResults);
```
## 2. Frontend
```
This is very simple to use in the frontend for custom forms. Like shown in the example below, it is straight forward to learn how to apply validation.
The rules here, can be either a sinle rule and a single json object or an array of rules. 
In the first inline method uses an array of validation rules and the second method in the init script uses a single json object to apply rules.

The validation happens on each input after clicking outside the input area, if the validation is successful it will show a basic green message.
If the validation fails, then it will show a basic red message and add a new class to mark as invalid input value. 
Once the user fills the form, then upon submitting the form will validate and continue if validation is successful and stops if not.

The rule has rule name which is the validation class, args which are optional and name which is optional to use in the message.
The validation results can be overriten by overriding the `Alaa/RvInputValidation/view/frontend/web/js/rv-input-results.js`
 
<form name="test_form" id="contact-form">
    <!-- Method 1 validate inline-->
    Email: <input type="text" id="email" class="input-text required" data-mage-init='{"rv-input-validator": {"rules": [{"rule": "email"}, {"rule": "NotEmpty"}], "name": "Email"}}'>
    Age: <input type="text" id="age" class="input-text required">
    <button type="submit" title="Submit" class="action submit primary">
        <span>Submit</span>
    </button>
</form>


<!-- Method 2 validate in init script tag-->
<script type="text/x-magento-init">
    {
        "#age": {
        "rv-input-validator": {"rules": {"rule": "between", "args": {"min": 18, "max": 22}}, "name": "Age"}}
    }
</script>

```
# Contribution
Feel free to raise issues and contribute

# Licence
MIT