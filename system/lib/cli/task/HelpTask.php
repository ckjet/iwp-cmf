<?php

class HelpTask extends BaseTask {

    public function mainAction($params = array()) {
        echo $this->textColor("Usage:\n", 'brown');
        echo "   cli [options] task_name[:method] [arguments]\n\n";
        echo $this->textColor("Options:\n", 'brown');
        echo "   -v                                  Display cli version\n";
        echo "   -h                                  Display this help message\n\n";
        echo $this->textColor("generate\n", 'brown');
        echo "   :app                                Generates a new appication\n";
        echo "   :module                             Generates a new module\n";
        echo "   :task                               Creates a skeleton class for a new task\n";
        echo $this->textColor("help\n", 'brown');
        echo "   Run for view cli help\n";
    }
    
    public function versionAction($params = array()) {
        echo $params[0];
    }

}
