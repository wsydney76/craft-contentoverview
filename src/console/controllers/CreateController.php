<?php

namespace wsydney76\contentoverview\console\controllers;

use craft\console\Controller;
use craft\helpers\App;
use craft\helpers\Console;
use craft\helpers\FileHelper;
use Exception;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;
use wsydney76\contentoverview\models\Action;
use wsydney76\contentoverview\models\Filter;
use wsydney76\contentoverview\models\Section;
use yii\console\ExitCode;
use function implode;
use function is_dir;
use function is_file;
use function is_string;
use function str_contains;
use function str_replace;
use function var_dump;
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
                'class' => new Section(),
                'items' => [
                    'section' => [
                        'prompt' => 'Section. Separate multiple section with comma (e.g. news,page)',
                        'splitToArray' => true
                    ],
                    'heading' => 'Heading',
                    'limit' => 'Limit',
                    'orderBy' => 'Order By (e.g. title)',
                    'imageField' => 'Image Field (fieldHandle)',
                    'layout' => 'Layout [list,cards,cardlets,line]',
                    'size' => 'Size [tiny,small,medium,large]',
                    'scope' => 'Show drafts [drafts,provisional,ownProvisional,all]',
                    'status' => 'Status [live,disabled,pending,expired]',
                    'search' => 'Enable Search [true,false]',

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
                'class' => new Filter(),
                'items' => [
                    'handle' => 'Handle',
                    'label' => 'Label'
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
                'class' => new Action(),
                'items' => [
                    'handle' => 'Handle',
                    'label' => 'Label',
                    'icon' => 'Icon (path to a svg file)',
                    'info' => 'Enter just one of the following actions!',

                    'cpAction' => [
                        'prompt' => 'Controller action',
                        'breakIfSet' => true
                    ],
                    'jsFunction' => [
                        'prompt' => 'JavaScript Function',
                        'breakIfSet' => true
                    ],
                    'popupTemplate' => [
                        'prompt' => 'Popup Template (template path inside your root)',
                        'breakIfSet' => true
                    ],
                    'slideoutTemplate' => 'Slideout Template (template path inside your root)',
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
            console::output('See docs for details: ' . $config['docs']);
        }

        console::output('Press ENTER to use the default value.');
        console::output('Please note that your input is not validated.');

        $reflection = new ReflectionClass($config['class']);


        foreach ($config['items'] as $key => $item) {

            if ($key === 'info') {
                Console::output($item);
                continue;
            }

            if (is_string($item)) {
                $item = ['prompt' => $item];
            }

            $property = $this->getPropertyString($reflection->getProperty($key), $key, $item);
            if ($property) {
                $properties[] = $property;
            }


            if (isset($item['breakIfSet'])) {
                break;
            }
        }

        if (!$properties && isset($config['default'])) {
            return $config['default'];
        }

        return implode(PHP_EOL, $properties);
    }

    protected function getPropertyString(ReflectionProperty $property, string $key, array $item): string
    {

        $value = $this->prompt($item['prompt'] . ': ');

        if (!$value) {
            return '';
        }

        $out = '    public ';

        $propertyType = $property->getType();

        if ($propertyType instanceof ReflectionNamedType) {
            if ($propertyType->allowsNull()) {
                $out .= '?';
            }
            $out .= $propertyType->getName() . ' $' . $key . ' = ';

            $out .= match ($propertyType->getName()) {
                'string' => $this->getQuotedString($value),
                default => $value
            };;

            $out .= ';';
        } else if ($propertyType instanceof ReflectionUnionType) {
            $types = [];
            foreach ($propertyType->getTypes() as $unionType) {
                $types[] = $unionType->getName();
            }
            $out .= implode('|', $types) . ' $' . $key . ' = ';

            if (isset($item['splitToArray']) && str_contains($value, ',')) {
                $arrayOut = [];
                foreach (explode(',', $value) as $string) {
                    $arrayOut[] = $this->getQuotedString($string);
                }

                $out .= '[' . implode(',', $arrayOut) . '];';
            } else {
                $out .= $this->getQuotedString($value) . ';';
            }
        }

        return $out;
    }

    protected function getQuotedString(string $value)
    {
        return "'" . str_replace("'", "\\'", $value) . "'";
    }
}