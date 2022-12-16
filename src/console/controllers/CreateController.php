<?php

namespace wsydney76\contentoverview\console\controllers;

use craft\console\Controller;
use craft\helpers\App;
use craft\helpers\Console;
use craft\helpers\FileHelper;
use Exception;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionUnionType;
use wsydney76\contentoverview\models\Action;
use wsydney76\contentoverview\models\Filter;
use wsydney76\contentoverview\models\Section;
use wsydney76\contentoverview\Plugin;
use yii\console\ExitCode;


class CreateController extends Controller
{

    protected string $sourceDir = '@wsydney76/contentoverview/scaffold';
    protected string $destDir = '@root/modules/contentoverview';

    public bool $trace = false;

    public function options($actionID): array
    {
        return ['trace'];
    }

    public function beforeAction($action): bool
    {

        $this->sourceDir = App::parseEnv($this->sourceDir);
        $this->destDir = App::parseEnv($this->destDir);

        $this->ensureDirectoryExists($this->destDir);

        return true;
    }

    public function actionModule(): int
    {

        if (!$this->copyFile('Module.txt', $this->destDir, 'Module.php')) {
            return false;
        }

        Console::output('https://wsydney76.github.io/craft-contentoverview/dev/module.html');

        return ExitCode::OK;
    }

    public function actionPluginConfig(): int
    {

        if (!$this->copyFile('contentoverview.txt', App::parseEnv('@config'), 'contentoverview.php')) {
            return false;
        }

        Console::output('https://wsydney76.github.io/craft-contentoverview/config/plugin-config.html');

        return ExitCode::OK;
    }

    public function actionPages(): int
    {
        $configPath = Plugin::getInstance()->getSettings()->configPath;

        if (!$this->copyFile('pages.txt', App::parseEnv($configPath), 'pages.php')) {
            return false;
        }

        Console::output('https://wsydney76.github.io/craft-contentoverview/config/pages-setup.html');

        return ExitCode::OK;
    }

    public function actionPage(): int
    {
        $configPath = Plugin::getInstance()->getSettings()->configPath;

        $pageKey = $this->prompt('Page Key: (lower letters, numbers and hyphen only. Starts with letter):', [
            'required' => true,
            'pattern' => '/^[a-z][a-z0-9-]*$/'
        ]);

        if (!$this->copyFile('page.txt', App::parseEnv($configPath), "{$pageKey}.php")) {
            return false;
        }

        Console::output('https://wsydney76.github.io/craft-contentoverview/config/page-config.html');

        return ExitCode::OK;
    }

    public function actionSection($className = ''): int
    {

        if (!$this->createClassFile(
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
                        'prompt' => 'Section handle(s)',
                        'splitToArray' => true,
                        'required' => true
                    ],
                    'heading' => 'Heading',
                    'limit' => 'Limit',
                    'orderBy' => 'Order By (e.g. title)',
                    'imageField' => 'Image Field (fieldHandle)',
                    'layout' => [
                        'prompt' => 'Layout',
                        'values' => 'list,cards,cardlets,line'
                    ],
                    'size' => [
                        'prompt' => 'Size',
                        'values' => 'tiny,small,medium,large'
                    ],
                    'info' => [
                        'prompt' => 'Info object template',
                        'default' => '{postDate|date("short")}'
                    ],
                    'scope' => [
                        'prompt' => 'Show drafts',
                        'values' => 'drafts,provisional,ownProvisional,all'
                    ],
                    'status' => [
                        'prompt' => 'Status',
                        'values' => 'live,disabled,pending,expired'
                    ],
                    'search' => [
                        'prompt' => 'Enable search',
                        'values' => 'true,false'
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

        if (!$this->createClassFile(
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

        if (!$this->createClassFile(
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
                    'infoText' => 'Enter just one of the following actions!',

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

        if (!$this->createClassFile(
            $this->sourceDir . '/Service.txt',
            'services',
            $className,
            'Class name for service')) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        console::output('https://wsydney76.github.io/craft-contentoverview/dev/service.html');

        return ExitCode::OK;
    }

    private function copyFile(string $sourceFileName, string $destDir, string $destFileName)
    {
        $destPath = $destDir . '/' . $destFileName;
        if (is_file($destPath)) {
            console::error("File $destFileName already exists.");
            return false;
        }

        try {
            $this->ensureDirectoryExists($destDir);
            copy($this->sourceDir . '/' . $sourceFileName, $destPath);
        } catch (Exception $e) {
            $this->exceptionError($e);
            return false;
        }

        console::output("File $destPath created.");
        console::output("See docs for usage.");

        return true;
    }

    protected function createClassFile($sourcePath, $dir, $className, $prompt = 'ClassName', $propertiesConfig = []): bool
    {
        if (!$className) {
            $className = $this->prompt("{$prompt}:", ['required' => true]);
        }

        try {

            if ($dir) {
                $this->ensureDirectoryExists("{$this->destDir}/{$dir}");
            }

            $destPath = $this->destDir . "/$dir/$className.php";

            if (is_file($destPath)) {
                console::error("File $destPath already exists.");
                return false;
            }

            file_put_contents($destPath, str_replace(
                [
                    '$CLASSNAME$',
                    '$PROPERTIES$'
                ],
                [
                    $className,
                    $this->getPropertiesFromConfig($propertiesConfig)
                ],
                file_get_contents($sourcePath)
            ));
        } catch (Exception $e) {
            $this->exceptionError($e);
            return false;
        }

        console::output("File $destPath created.");
        console::output('Refer to docs on how to activate your new class.');

        return true;
    }

    protected function exeptionError(Exception $e)
    {
        console::error('Could not create file. Error message:');
        console::error($e->getMessage());
        if ($this->trace) {
            console::error($e->getTraceAsString());
        } else {
            console::error('add --trace=1 to see the source of the error');
        }
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

        if (isset($config['info'])) {
            console::output($config['info']);
        }

        if (isset($config['docs'])) {
            console::output('See docs for details: ' . $config['docs']);
        }

        console::output('Press ENTER to use the default value, CTRL+c to cancel.');
        console::output('Please note that your input is not validated.');


        $properties = [];
        $reflection = new ReflectionClass($config['class']);


        foreach ($config['items'] as $key => $item) {

            if ($key === 'infoText') {
                Console::output($item);
                continue;
            }

            if (is_string($item)) {
                $item = ['prompt' => $item];
            }

            $property = $this->getPropertyString($reflection, $key, $item);
            if ($property) {
                $properties[] = $property;
                if (isset($item['breakIfSet'])) {
                    break;
                }
            }
        }

        if (!$properties && isset($config['default'])) {
            return $config['default'];
        }

        return implode(PHP_EOL, $properties);
    }

    protected function getPropertyString(ReflectionClass $reflection, string $key, array $item): ?string
    {

        $splitToArray = isset($item['splitToArray']) && $item['splitToArray'];

        $options = $item['options'] ?? [];

        if (isset($item['required'])) {
            $options['required'] = $item['required'];
        }

        if (isset($item['default'])) {
            $options['default'] = $item['default'];
        }

        if (isset($item['values'])) {
            $item['prompt'] = sprintf('%s [%s]', $item['prompt'], $item['values']);
            $options['validator'] = function($value, &$error) use ($item) {
                if (!in_array($value, explode(',', $item['values']), true)) {
                    $error = 'Invalid input.';
                    return false;
                }
                return true;
            };
        }

        if ($splitToArray) {
            $item['prompt'] = sprintf('%s [%s]', $item['prompt'], 'Separate multiple answers with comma (a,b)');
        }

        $value = $this->prompt($item['prompt'] . ': ', $options);

        if (!$value) {
            return null;
        }

        $property = $reflection->getProperty($key);
        $nullable = '';
        $type = 'mixed';

        $propertyType = $property->getType();

        if ($propertyType instanceof ReflectionNamedType) {
            if ($propertyType->allowsNull()) {
                $nullable = '?';
            }
            $type = $propertyType->getName();

            $value = match ($propertyType->getName()) {
                'string' => $this->getQuotedString($value),
                default => $value
            };;
        } else if ($propertyType instanceof ReflectionUnionType) {
            $types = [];
            foreach ($propertyType->getTypes() as $unionType) {
                $types[] = $unionType->getName();
            }
            $type = implode('|', $types);

            if ($splitToArray && str_contains($value, ',')) {
                $value = $this->getArrayString($value);
            } else {
                $value = $this->getQuotedString($value);
            }
        }

        return sprintf('    public %s%s $%s = %s;', $nullable, $type, $key, $value);
    }

    protected function getQuotedString(string $value)
    {
        if (str_starts_with($value, "'") && str_ends_with($value, "'")) {
            return $value;
        }

        if (str_starts_with($value, '"') && str_ends_with($value, '"')) {
            return $value;
        }

        return sprintf("'%s'", trim(str_replace("'", "\\'", $value)));
    }

    protected function getArrayString(string $value): string
    {
        $tempArray = [];
        foreach (explode(',', $value) as $string) {
            $tempArray[] = $this->getQuotedString($string);
        }

        return sprintf('[%s]', implode(',', $tempArray));
    }
}