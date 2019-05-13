<?php declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\ECS\Components\BulletCollidableComponent;
use App\ECS\Components\DroneBeeComponent;
use App\ECS\Components\HealthComponent;
use App\ECS\Components\PlayerComponent;
use App\ECS\Components\WorkerBeeComponent;
use App\ECS\EntityManager;
use App\ECS\Components\TransformationComponent;
use App\ECS\Components\SquareComponent;
use App\ECS\Systems\BulletCollidableSystem;
use App\ECS\Systems\BulletSystem;
use App\ECS\Systems\DeathSystem;
use App\ECS\Systems\DrawSquaresSystem;
use App\ECS\Components\EnemyComponent;
use App\ECS\Components\QueenBeeComponent;
use App\ECS\Systems\EnemySystem;
use App\ECS\Systems\HealthSystem;
use App\ECS\Systems\PlayerSystem;
use App\ScreenManager;

$screenManager = new ScreenManager();
$entityManager = new EntityManager();

$cols = exec('tput cols');
$lines = exec('tput lines');
$centerX = $cols / 2;
$centerY = $lines / 2;

system('clear');


//Move arrows
// left 27, 91, 68
// right 27, 91, 67
// up 27, 91, 65
// down 27, 91, 66


$events = [];
function pullEvents() : void {
    global $events;
    global $handle;

    $events = [];
    $c = fgetc($handle);

    if ($c) {
        $code = ord($c);

        switch($code) {
            case 27:
                $special = [];
                while ($c2 = fgetc($handle)) {
                    $special[] = ord($c2);
                }

                switch (implode('', $special)) {
                    case '':
                        $events[] = 'KEY_PRESSED_ESC';
                    break;
                    case '9168':
                        $events[] = 'KEY_PRESSED_ARROW_LEFT';
                    break;
                    case '9167':
                        $events[] = 'KEY_PRESSED_ARROW_RIGHT';
                    break;
                    case '9165':
                        $events[] = 'KEY_PRESSED_ARROW_UP';
                    break;
                    case '9166':
                        $events[] = 'KEY_PRESSED_ARROW_DOWN';
                    break;
                }
            break;
            case 32:
                $events[] = 'KEY_PRESSED_SPACE';
                break;
        }
    }
}

function poolEvents() : ?string
{
    global $events;

    if (count($events)) {
        return array_shift($events);
    }

    return null;
}

function hasEvent(string $event) : bool
{
    global $events;

    foreach ($events as $k => $e) {
        if ($e == $event) {
            unset($events[$k]);
            return true;
        }
    }

    return false;
}

($entityManager->makeEntity())
    ->addComponents(
        new TransformationComponent($centerX, $screenManager->getLines() - 9, 10, 8),
        new SquareComponent(),
        new PlayerComponent()
    );

($entityManager->makeEntity())
    ->addComponents(
        new TransformationComponent($centerX, 0, 6, 6),
        new SquareComponent(),
        new QueenBeeComponent(),
        new EnemyComponent(15),
        new HealthComponent(),
        new BulletCollidableComponent(8)

    );

$workerBeeTotal = 6;
$workerBeeStartPos = 10;
$workerBeeWidth = 6;
while ($workerBeeTotal--) {
    ($entityManager->makeEntity())
        ->addComponents(
            new TransformationComponent($workerBeeStartPos, 7, $workerBeeWidth, 2),
            new SquareComponent(),
            new EnemyComponent(),
            new WorkerBeeComponent(),
            new HealthComponent(75),
            new BulletCollidableComponent(10)
        );

    $workerBeeStartPos += $workerBeeWidth + 2;
}

$droneBeeTotal = 9;
$droneBeeStartPos = 5;
$droneBeeWidth = 10;
while ($droneBeeTotal--) {
    ($entityManager->makeEntity())
        ->addComponents(
            new TransformationComponent($droneBeeStartPos, 10, $droneBeeWidth, 3),
            new SquareComponent(),
            new EnemyComponent(),
            new DroneBeeComponent(),
            new HealthComponent(50),
            new BulletCollidableComponent(12)

        );

    $droneBeeStartPos += $droneBeeWidth + 2;
}


$drawSquaresSystem = new DrawSquaresSystem($entityManager, $screenManager);
$enemySystem = new EnemySystem($entityManager, $screenManager);
$playerSystem = new PlayerSystem($entityManager, $screenManager);
$healthSystem = new HealthSystem($entityManager, $screenManager);
$bulletSystem = new BulletSystem($entityManager, $screenManager);
$bulletCollidableSystem = new BulletCollidableSystem($entityManager, $screenManager);
$deathSystem = new DeathSystem($entityManager, $screenManager);


system('stty cbreak -echo');
system('setterm -cursor off');

register_shutdown_function(function() { system('setterm -cursor on'); });

$handle = fopen ("php://stdin","r");
stream_set_blocking($handle, false);

$screenManager->clear();

while (true) {
    pullEvents();

    if (hasEvent('KEY_PRESSED_ESC')) {
        break;
    }

    $screenManager->clear();

    $playerSystem->update();
    $enemySystem->update();
    $healthSystem->update();
    $bulletSystem->update();
    $drawSquaresSystem->update();
    $bulletCollidableSystem->update();
    $deathSystem->update();

    usleep(1250);
}

fclose($handle);
system('stty sane');
system('clear');


