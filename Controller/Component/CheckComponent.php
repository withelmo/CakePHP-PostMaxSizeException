<?php

App::uses('Component', 'Controller');
App::uses('PostMaxSizeChecker', 'PostMaxSizeException.Lib');
App::uses('RequestEntityTooLargeException', 'PostMaxSizeException.Error');

class CheckComponent extends Component {

    /**
     * initialize
     *
     * @access public
     * @param
     * @return
     */
    public function initialize(Controller $controller) {

        $autoException = true;
        if (isset($this->settings['autoException'])) {
           $autoException = $this->settings['autoException'];
        }

        if ($autoException && !$this->check()) {
            throw new RequestEntityTooLargeException();
        }
    }

    /**
     * アップロード総量がアップロード制限以下かどうかの判定
     * maxsizeCheck
     *
     * @return boolean
     */
    public function check() {
        $checker = new PostMaxSizeChecker();

        return $checker->check();
    }
}