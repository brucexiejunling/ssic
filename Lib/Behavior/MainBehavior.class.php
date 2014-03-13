<?php 
class MainBehavior extends Behavior {

       
        // 行为参数定义
        protected $options   =  array(
            'test_param' => true,   //  行为参数 会转换成TEST_PARAM配置参数
        );
        // 行为扩展的执行入口必须是run
        public function run(&$params){
            if(C('TEST_PARAM')) {
                echo 'RUNTEST BEHAVIOR '.$params;
            }
        }

}
 ?>
