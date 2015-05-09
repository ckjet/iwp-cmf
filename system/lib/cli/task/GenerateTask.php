<?php

use Phalcon\Config\Adapter\Yaml as Yaml;

class GenerateTask extends BaseTask {

    public function mainAction($params = array()) {
        echo $this->textColor('Available methods', 'brown') . "\n";
        echo "   :app app_name                       Generates a new application\n";
        echo "   :module app_name module_name        Generates a new module\n";
        echo "   :task task_name                     Creates a skeleton class for a new task\n";
        var_dump($this->app_root);
    }

    public function taskAction($params = array()) {
        $taskName = ucfirst(isset($params[0]) ? $params[0] : false);
        if (!$taskName) {
            echo $this->textColor('Empty task name', 'red:bold') . "\n";
        } elseif (!preg_match('/^[a-zA-Z]+$/', $taskName)) {
            echo $this->textColor('Invalid task name', 'red:bold') . "\n";
            echo "   Use only english characters\n";
        } elseif(in_array(strtolower($taskName), array('help', 'generate'))) {
            echo $this->textColor('This task name is reserved by system', 'red:bold') . "\n";
        } elseif (class_exists($taskName . 'Task')) {
            echo $this->textColor('Task [' . $taskName . '] is already exist', 'red:bold') . "\n";
        } elseif (!is_writable($this->app_root . '/lib/task')) {
            echo $this->textColor('Task dir is not writable', 'red:bold') . "\n";
        } else {
            echo $this->textColor('Creating task [' . $taskName . ']', 'brown') . "\n";
            echo "Creating " . $this->app_root . "/lib/task/" . $taskName . "Task.php\n";
            $template = file_get_contents($this->app_root . '/lib/cli/generate/task/task.txt');
            $task_template = str_replace('{task_name}', $taskName . 'Task', $template);
            $task_file = fopen($this->app_root . '/lib/task/' . $taskName . 'Task.php', 'a');
            fwrite($task_file, $task_template);
            fclose($task_file);
            echo $this->textColor('Task successful created!', 'green:bold') . "\n";
        }
    }

    public function moduleAction($params = array()) {
        $project = new Yaml($this->app_root . '/config/project.yml');
        $app = isset($params[0]) ? $params[0] : false;
        $module = isset($params[1]) ? $params[1] : false;
        $appDir = $this->app_root . '/apps/' . $app;
        $moduleFile = $this->app_root . '/apps/' . $app . '/controller/' . ucfirst($module) . 'Controller.php';
        $viewDir = $this->app_root . '/apps/' . $app . '/view/' . $module;
        $viewFile = $this->app_root . '/apps/' . $app . '/view/' . $module . '/index.volt';
        if (!$app) {
            echo $this->textColor('Empty application name', 'red:bold') . "\n";
        } elseif (!$module) {
            echo $this->textColor('Empty module name', 'red:bold') . "\n";
        } elseif (!preg_match('/^[a-zA-Z]+$/', $module)) {
            echo $this->textColor('Invalid module name', 'red:bold') . "\n";
            echo "   Use only english characters in app name\n";
        } elseif (!is_dir($appDir)) {
            echo $this->textColor('Application [' . $app . '] is not exist', 'red:bold') . "\n";
        } elseif (is_file($moduleFile) || is_dir($viewDir) || is_file($viewFile)) {
            echo $this->textColor('Module [' . $module . '] is already exist', 'red:bold') . "\n";
        } elseif (!is_writable($this->app_root . '/apps/' . $app . '/view')) {
            echo $this->textColor('View dir is not writable', 'red:bold') . "\n";
        } elseif (!is_writable($this->app_root . '/apps/' . $app . '/controller')) {
            echo $this->textColor('Controller dir is not writable', 'red:bold') . "\n";
        } else {
            echo $this->textColor('Creating module [' . $module . ']', 'brown') . "\n";
            echo "Creating " . $moduleFile . "\n";
            $module_template = file_get_contents($this->app_root . '/lib/cli/generate/module/controller.txt');
            $module_patern = array('{module_name}', '{class_name}', '{author_name}', '{project_name}');
            $module_replace = array($module, ucfirst($module) . 'Controller', $project->author_name, $project->project_name);
            $module_template_content = str_replace($module_patern, $module_replace, $module_template);
            $module_file = fopen($moduleFile, 'a');
            fwrite($module_file, $module_template_content);
            fclose($module_file);
            echo "Creating " . $viewDir . "\n";
            mkdir($viewDir);
            echo "Creating " . $viewFile . "\n";
            $view_template = file_get_contents($this->app_root . '/lib/cli/generate/module/view.txt');
            $view_template_content = str_replace('{module_name}', $module, $view_template);
            $view_file = fopen($this->app_root . '/apps/' . $app . '/view/' . $module . '/index.volt', 'a');
            fwrite($view_file, $view_template_content);
            fclose($view_file);
            echo $this->textColor('Module successful created!', 'green:bold') . "\n";
        }
    }

    public function appAction($params = array()) {
        $appName = isset($params[0]) ? $params[0] : false;
        $appsDir = $this->app_root . '/apps';
        $project = new Yaml($this->app_root . '/config/project.yml');
        $forCreate = array(
            'dirs' => array(
                'app' => $this->app_root . '/apps/' . $appName,
                'controller' => $this->app_root . '/apps/' . $appName . '/controller',
                'view' => $this->app_root . '/apps/' . $appName . '/view',
                'app_view' => $this->app_root . '/apps/' . $appName . '/view/main',
                'error_view' => $this->app_root . '/apps/' . $appName . '/view/errors',
                'config' => $this->app_root . '/apps/' . $appName . '/config',
                'model' => $this->app_root . '/apps/' . $appName . '/model'
            ),
            'files' => array(
                'app' => array(
                    'file' => $this->root . '/public/' . $appName . '.php',
                    'source' => $this->app_root . '/lib/cli/generate/app/app.txt',
                    'replace' => array(
                        'patern' => array('{app_name}'),
                        'data' => array($appName)
                    )
                ),
                'main_conroller' => array(
                    'file' => $this->app_root . '/apps/' . $appName . '/controller/MainController.php',
                    'source' => $this->app_root . '/lib/cli/generate/app/controller.txt',
                    'replace' => array(
                        'patern' => array('{module_name}', '{class_name}', '{author_name}', '{project_name}'),
                        'data' => array('main', 'MainController', $project->author_name, $project->project_name)
                    )
                ),
                'errors_conroller' => array(
                    'file' => $this->app_root . '/apps/' . $appName . '/controller/ErrorsController.php',
                    'source' => $this->app_root . '/lib/cli/generate/app/errors_controller.txt',
                    'replace' => array(
                        'patern' => array('{author_name}', '{project_name}'),
                        'data' => array($project->author_name, $project->project_name)
                    )
                ),
                'app_view' => array(
                    'file' => $this->app_root . '/apps/' . $appName . '/view/index.volt',
                    'source' => $this->app_root . '/lib/cli/generate/app/main_view.txt',
                    'replace' => array(
                        'patern' => array(),
                        'data' => array()
                    )
                ),
                'errors_view' => array(
                    'file' => $this->app_root . '/apps/' . $appName . '/view/errors.volt',
                    'source' => $this->app_root . '/lib/cli/generate/app/errors_view.txt',
                    'replace' => array(
                        'patern' => array(),
                        'data' => array()
                    )
                ),
                'main_view' => array(
                    'file' => $this->app_root . '/apps/' . $appName . '/view/main/index.volt',
                    'source' => $this->app_root . '/lib/cli/generate/app/view.txt',
                    'replace' => array(
                        'patern' => array('{module_name}'),
                        'data' => array('main')
                    )
                ),
                'error404_view' => array(
                    'file' => $this->app_root . '/apps/' . $appName . '/view/errors/show404.volt',
                    'source' => $this->app_root . '/lib/cli/generate/app/show404_view.txt',
                    'replace' => array()
                ),
                'error500_view' => array(
                    'file' => $this->app_root . '/apps/' . $appName . '/view/errors/show500.volt',
                    'source' => $this->app_root . '/lib/cli/generate/app/show500_view.txt',
                    'replace' => array()
                ),
                'config' => array(
                    'file' => $this->app_root . '/apps/' . $appName . '/config/config.yml',
                    'source' => $this->app_root . '/lib/cli/generate/app/config.txt',
                    'replace' => array(
                        'patern' => array('{app_name}'),
                        'data' => array($appName)
                    )
                ),
                'cache' => array(
                    'file' => $this->app_root . '/apps/' . $appName . '/config/cache.yml',
                    'source' => $this->app_root . '/lib/cli/generate/app/cache.txt',
                    'replace' => array(
                        'patern' => array(),
                        'data' => array()
                    )
                ),
                'routing' => array(
                    'file' => $this->app_root . '/apps/' . $appName . '/config/routing.yml',
                    'source' => $this->app_root . '/lib/cli/generate/app/routing.txt',
                    'replace' => array(
                        'patern' => array(),
                        'data' => array()
                    )
                )
            )
        );
        if (!$appName) {
            echo $this->textColor('Empty app name', 'red:bold') . "\n";
        } elseif (!preg_match('/^[a-zA-Z]+$/', $appName)) {
            echo $this->textColor('Invalid app name', 'red:bold') . "\n";
            echo "   Use only english characters\n";
        } elseif ($this->check($forCreate['dirs'], 'is_dir')) {
            echo $this->textColor('App [' . $appName . '] is already exist', 'red:bold') . "\n";
        } elseif (!is_writable($appsDir)) {
            echo $this->textColor('App dir is not writable', 'red:bold') . "\n";
        } else {
            echo $this->textColor('Creating app [' . $appName . ']', 'brown') . "\n";
            foreach ($forCreate as $k => $v) {
                echo "Creating {$k}\n";
                foreach ($forCreate[$k] as $k2 => $v2) {
                    if ($k == 'dirs') {
                        echo "Creating {$k2} dir {$v2}\n";
                        mkdir($v2);
                    } elseif ($k == 'files') {
                        echo "Creating {$k2} file {$v2['file']}\n";
                        $file_content = file_get_contents($v2['source']);
                        $file_data = $file_content;
                        if (sizeof($v2['replace']) > 0) {
                            $file_data = str_replace($v2['replace']['patern'], $v2['replace']['data'], $file_data);
                        }
                        $new_file = fopen($v2['file'], 'a');
                        fwrite($new_file, $file_data);
                        fclose($new_file);
                    }
                }
            }
            die();
            echo "Creating " . $this->app_root . "/lib/task/" . $appName . "Task.php\n";
            $template = file_get_contents($this->app_root . '/lib/cli/generate/task.txt');
            $task_template = str_replace('{task_name}', $appName . 'Task', $template);
            $task_file = fopen($this->app_root . '/lib/task/' . $appName . 'Task.php', 'a');
            fwrite($task_file, $task_template);
            fclose($task_file);
            echo $this->textColor('Task successful created!', 'green:bold') . "\n";
        }
    }

    protected function check($array, $func) {
        if (is_array($array)) {
            foreach ($array as $v) {
                if ($func($v)) {
                    return true;
                }
            }
        } elseif (is_string($array)) {
            if ($func($v)) {
                return true;
            }
        } else {
            return true;
        }
        return false;
    }

}
