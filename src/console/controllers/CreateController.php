<?php

namespace wsydney76\contentoverview\console\controllers;

use craft\console\Controller;
use craft\helpers\App;
use craft\helpers\FileHelper;
use Exception;
use yii\console\ExitCode;
use yii\helpers\BaseConsole;
use function is_dir;
use function is_file;
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

        $this->stdout('https://wsydney76.github.io/craft-contentoverview/dev/module.html' . PHP_EOL);

        return ExitCode::OK;
    }

    public function actionSection($className = ''): int
    {

        if (!$this->createFile(
            $this->sourceDir . '/Section.txt',
            'models',
            $className,
            'Class name for section [e.g. NewsSection]')) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $this->stdout('https://wsydney76.github.io/craft-contentoverview/dev/section.html' . PHP_EOL);

        return ExitCode::OK;
    }

    public function actionFilter($className = ''): int
    {

        if (!$this->createFile(
            $this->sourceDir . '/Filter.txt',
            'models',
            $className,
            'Class name for filter [e.g. CriticalReviewsFilter]')) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $this->stdout('https://wsydney76.github.io/craft-contentoverview/dev/filter.html' . PHP_EOL);

        return ExitCode::OK;
    }

    public function actionAction($className = ''): int
    {

        if (!$this->createFile(
            $this->sourceDir . '/Action.txt',
            'models',
            $className,
            'Class name for action [e.g. PublishAction]')) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $this->stdout('https://wsydney76.github.io/craft-contentoverview/dev/action.html' . PHP_EOL);

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

        $this->stdout('https://wsydney76.github.io/craft-contentoverview/dev/service.html' . PHP_EOL);

        return ExitCode::OK;
    }

    protected function createFile($sourceFile, $dir, $className, $prompt = 'ClassName'): bool
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
                $this->stdout("File $destFile already exists." . PHP_EOL);
                return false;
            }
            file_put_contents($destFile, str_replace(
                [
                    '$CLASSNAME$'
                ],
                [
                    $className
                ],
                file_get_contents($sourceFile)
            ));
        } catch (Exception $e) {
            $this->stderr('Could not create file. Error message:' . PHP_EOL, BaseConsole::FG_RED);
            $this->stderr($e->getMessage() . PHP_EOL);
            return false;
        }

        $this->stdout("File $destFile created." . PHP_EOL, BaseConsole::FG_GREEN);
        $this->stdout('Refer to docs on how to activate your new class.' . PHP_EOL);

        return true;
    }

    protected function ensureDirectoryExists($dir)
    {
        if (!is_dir($dir)) {
            FileHelper::createDirectory($dir);
            $this->stdout("Module directory $dir created." . PHP_EOL);
        }
    }
}