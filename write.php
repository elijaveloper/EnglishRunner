<?php
class Logger {

    private
        $file,
        $timestamp;

    public function __construct($filename) {
        $this->file = $filename;
    }

    public function setTimestamp($format) {
        $this->timestamp = "{\"timestamp\":\"" . date($format) . "\"";
    }

    public function putLog($insert) {
        if (isset($this->timestamp)) {
            file_put_contents($this->file, $this->timestamp . ",\"log\":" .  $insert . "},\n", FILE_APPEND);
        }
    }

    public function getLog() {
        $content = @file_get_contents($this->file);
        return $content;
    }

}

$log = new Logger("log.txt");
$log->setTimestamp("D M d 'y h.i A");

if (isset($_POST['package'])) {
  $log->putLog($_POST['package']);
}

?>
