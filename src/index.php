<?php 

//phpinfo();

class test {
    public function __construct() {
        echo "Hello World!";
    }
}

$test = new test();

class Html {

    public function elm($element, $content, $options = []) {
        $html = "<{$element}";
            foreach($options as $key => $value) {
                $html .= " {$key}=\"{$value}\"";
            }
        $html .= ">$content</{$element}>";

        return $html;
    }


}