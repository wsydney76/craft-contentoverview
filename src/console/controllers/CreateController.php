<?php

namespace wsydney76\contentoverview\console\controllers;

use craft\console\Controller;
use craft\helpers\App;
use craft\helpers\Console;
use craft\helpers\FileHelper;
use Exception;
use yii\console\ExitCode;
use yii\helpers\BaseConsole;
use function implode;
use function is_dir;
use function is_file;
use function sprintf;
use const PHP_EOL;

class CreateController extends Controller
{
    protected string $sourceDir = '@wsydney76/contentoverview/scaffold';
    protected string $destDir = '@root/modules/contentoverview';

    public function beforeAction($action): bool
    {

        $this->sourceDir = App::parseEnv($this->sourceDir);
        $this->destDir = App::parseEnv($this->destDir);

        $this->ensureDirectoryExists($this->destDir);

        return true;
    }

    public function actionModule(): int
    {

        if (!$this->createFile(
            $this->sourceDir . '/Module.txt',
            '',
            'Module')) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        Console::output('https://wsydney76.github.io/craft-contentoverview/dev/module.html');

        return ExitCode::OK;
    }

    public function actionSection($className = ''): int
    {

        if (!$this->createFile(
            $this->sourceDir . '/Section.txt',
            'models',
            $className,
            'Class name for section [e.g. NewsSection]',
            [
                'info' => 'Enter section settings.',
                'docs' => 'https://wsydney76.github.io/craft-contentoverview/config/section-settings.html',
                'default' => '// Your defaults go here',
                'items' => [
                    [
                        'prompt' => 'Section handle',
                        'template' => 'public array|string $section = \'%s\';'
                    ],
                    [
                        'prompt' => 'Heading',
                        'template' => 'public ?string $heading = \'%s\';'
                    ],
                    [
                        'prompt' => 'Limit',
                        'template' => 'public ?int $limit = %s;'
                    ],
                    [
                        'prompt' => 'Order By (e.g. title)',
                        'template' => 'public array|string $orderBy = \'%s\';'
                    ],
                    [
                        'prompt' => 'Image Field (fieldHandle)',
                        'template' => 'public array|string $imageField = \'%s\';'
                    ],
                    [
                        'prompt' => 'Layout [list,cards,cardlets,line]',
                        'template' => 'public ?string $layout = \'%s\';',
                    ],
                    [
                        'prompt' => 'Size [tiny,small,medium,large]',
                        'template' => 'public ?string $size = \'%s\';',
                    ],
                    [
                        'prompt' => 'Show drafts [drafts,provisional,ownProvisional,all]',
                        'template' => 'public ?string $scope = \'%s\';',
                    ],
                    [
                        'prompt' => 'Status [live,disabled,pending,expired]',
                        'template' => 'public ?string $status = \'%s\';',
                    ],
                    [
                        'prompt' => 'Enable Search [true,false]',
                        'template' => 'public bool $search = %s;',
                    ],
                ]
            ]
        )) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        console::output('https://wsydney76.github.io/craft-contentoverview/dev/section.html');
        console::output("\$co->createSection({$className}::class)");

        return ExitCode::OK;
    }

    public function actionFilter($className = ''): int
    {

        if (!$this->createFile(
            $this->sourceDir . '/Filter.txt',
            'models',
            $className,
            'Class name for filter [e.g. CriticalReviewsFilter]',
            [
                'info' => 'Enter filter settings.',
                'docs' => 'https://wsydney76.github.io/craft-contentoverview/pagecontent/filters.html#custom-filters',
                'default' => '// Your defaults go here',
                'items' => [
                    [
                        'prompt' => 'Handle',
                        'template' => 'public string $handle = \'%s\';'
                    ],
                    [
                        'prompt' => 'Label',
                        'template' => 'public string $label = \'%s\';'
                    ],
                ]
            ])) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        console::output('https://wsydney76.github.io/craft-contentoverview/dev/filter.html');

        return ExitCode::OK;
    }

    public function actionAction($className = ''): int
    {

        if (!$this->createFile(
            $this->sourceDir . '/Action.txt',
            'models',
            $className,
            'Class name for action [e.g. PublishAction]',
            [
                'info' => 'Enter action settings.',
                'docs' => 'https://wsydney76.github.io/craft-contentoverview/dev/action.html',
                'default' => '// Your defaults go here',
                'items' => [
                    [
                        'prompt' => 'Handle',
                        'template' => 'public string $handle = \'%s\';'
                    ],
                    [
                        'prompt' => 'Label',
                        'template' => 'public string $label = \'%s\';'
                    ],
                    [
                        'prompt' => 'Icon (path to a svg file)',
                        'template' => 'public string $icon = \'%s\';'
                    ],
                    [
                        'info' => 'Enter just one of the following actions!'
                    ],
                    [
                        'prompt' => 'Controller action',
                        'template' => 'public string $cpAction = \'%s\';',
                        'breakIfSet' => true
                    ],
                    [
                        'prompt' => 'JavaScript Function',
                        'template' => 'public string $jsFunction = \'%s\';',
                        'breakIfSet' => true
                    ],
                    [
                        'prompt' => 'Popup Template (template path inside your root)',
                        'template' => 'public string $popupTemplate = \'%s\';',
                        'breakIfSet' => true
                    ],
                    [
                        'prompt' => 'Slideout Template (template path inside your root)',
                        'template' => 'public string $slideoutTemplate = \'%s\';'
                    ],
                ]
            ])) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        console::output('https://wsydney76.github.io/craft-contentoverview/dev/action.html');

        return ExitCode::OK;
    }

    public function actionService($className = ''): int
    {

        if (!$this->createFile(
            $this->sourceDir . '/Service.txt',
            'services',
            $className,
            'Class name for service')) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        console::output('https://wsydney76.github.io/craft-contentoverview/dev/service.html');

        return ExitCode::OK;
    }

    protected function createFile($sourceFile, $dir, $className, $prompt = 'ClassName', $propertiesConfig = []): bool
    {
        if (!$className) {
            $className = $this->prompt("{$prompt}:");
            if (!$className) {
                return false;
            }
        }

        try {

            if ($dir) {
                $this->ensureDirectoryExists("{$this->destDir}/{$dir}");
            }

            $destFile = $this->destDir . "/$dir/$className.php";
            if (is_file($destFile)) {
                console::error("File $destFile already exists.");
                return false;
            }
            file_put_contents($destFile, str_replace(
                [
                    '$CLASSNAME$',
                    '$PROPERTIES$'
                ],
                [
                    $className,
                    $this->getPropertiesFromConfig($propertiesConfig)
                ],
                file_get_contents($sourceFile)
            ));
        } catch (Exception $e) {
            console::error('Could not create file. Error message:');
            console::error($e->getMessage());
            return false;
        }

        console::output("File $destFile created.");
        console::output('Refer to docs on how to activate your new class.');

        return true;
    }

    protected function ensureDirectoryExists($dir)
    {
        if (!is_dir($dir)) {
            FileHelper::createDirectory($dir);
            console::output("Directory $dir created.");
        }
    }

    protected function getPropertiesFromConfig($config)
    {
        if (!$config) {
            return '';
        }

        $properties = [];

        if (isset($config['info'])) {
            console::output($config['info']);
        }

        if (isset($config['docs'])) {
            console::output('See docs for details: '. $config['docs']);
        }

        console::output('Press ENTER to use the default value.');
        console::output('Please note that your input is not validated.');

        foreach ($config['items'] as $item) {

            if (isset($item['info'])) {
                Console::output($item['info']);
                continue;
            }

            $value = $this->prompt($item['prompt'] . ': ');

            if ($value) {
                $properties[] = '    ' . sprintf($item['template'], $value);
                if (isset($item['breakIfSet'])) {
                    break;
                }
            }
        }

        if (!$properties && isset($config['default']))  {
            return $config['default'];
        }

        return implode(PHP_EOL, $properties);
    }
}