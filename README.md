# :crystal_ball: Solve all your problems with this framework! (or maybe not)

Prerequisites:

- php >= 8.0
- pm2

## Steps to run a script using this framework:

### 1) Create the files

- Create a folder named as you want (we will use _Example/_ in this example)
- Create a file named _entrypoint.php_, this will be the entrypoint of you solution
- Create a file for your actual script class (_ExampleScript.php_)
- Create a file for you script parameters class (_ExampleParameters.php_)

### 2) Define the parameters you will need in your script

Your class has to extend the **Solver\Parameters** class.

```php
<?php

namespace Solutions\Example;

use Solver\Parameters;

class ExampleParameters extends Parameters
{
    public function __construct(
        public ?int $sleepTime = 0,
    ) {}
}
```

Every attribute must be optional in the constructor and have a default value.

### 3) Write your script

Now extend the **Script** class and implement a constructor that accepts the previously defined parameters and a run function containg the actual script code.

```php
<?php

namespace Solutions\Example;

use Solver\Script;

class ExampleScript extends Script
{
    public function __construct(protected ExampleParameters $params) {}

    public function run()
    {
        sleep($this->params->sleepTime);
        return json_encode([
            'slept' => $this->params->sleepTime
        ]);
    }
}
```

### 4) Write your entrypoint

As last thing we need to istantiate the solution and execute it as it follows.

To the solution you must provide

- the script class of the script you want to run
- a collection of parameters which for every instance the script will be executed
- a Runner, actually there are 2 implementations of the runner, the **SyncRunner**, to run the solution synchronusly and a **ShellRunner** that runs parallel processes by launching the script for each istance of the parameters using pm2
- an optional Notifier if you want a notify with your script results, at the moment there is only an implementation that uses **Telegram**, for this to work you need to set the TELEGRAM_BOT_TOKEN and TELEGRAM_CHAT_ID envs in the env.php file

```php
<?php

namespace Solutions\Example;

require_once __DIR__ . "/../../vendor/autoload.php";

use Solver\Runners\ShellRunner\ShellRunner;
use Solver\Runners\SyncRunner\SyncRunner;
use Solver\Solution;

$solution = new Solution(
    ExampleScript::class,
    collect([
        new ExampleParameters(sleepTime: 5),
        new ExampleParameters(sleepTime: 100),
        new ExampleParameters(sleepTime: 0),
    ]),
    // new SyncRunner,
    new ShellRunner,
    new TelegramNotifier,
);

$solution->run();
```

At the end you will find a new folder in your script directory (_solutions/Example/files/output_) for the execution containing a file with the output for each Parameter instance you provided to the Solution, if you passed also a notifier you will receive a notificatin with the output file.

You will also find pm2 logs inside you root dir in the _files/logs_ folder.
