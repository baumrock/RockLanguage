<?php namespace ProcessWire;
/**
 * @author Bernhard Baumrock, 05.06.2022
 * @license Licensed under MIT
 * @link https://www.baumrock.com
 */
class RockLanguage extends WireData implements Module, ConfigurableModule {

  public static function getModuleInfo() {
    return [
      'title' => 'RockLanguage',
      'version' => '1.0.0',
      'summary' => 'Easily manage and ship translation files for your modules',
      'autoload' => true,
      'singular' => true,
      'icon' => 'language',
    ];
  }

  public function init() {
    $this->sync();
  }

  /**
   * Copy file if it is newer
   */
  public function copyIfNewer($from, $to, $toName) {
    if(is_file($to) AND filemtime($from) <= filemtime($to)) return;
    $this->wire->files->copy($from, $to);
    $fromName = basename($from);
    $this->log("Copied $fromName to $toName");
  }

  public function getCustomCodes() {
    $codes = [];
    foreach(explode("\n", $this->customCodes) as $line) {
      $parts = explode("=", $line, 2);
      if(count($parts)!=2) continue;
      $codes[$parts[0]] = $parts[1];
    }
    return $codes;
  }

  /**
   * @return array
   */
  public function getLanguageCodes($returnString = false) {
    $codes = [];
    $string = '';
    $custom = $this->getCustomCodes();
    foreach($this->wire->languages as $lang) {
      $code = strtoupper($lang->name);
      if(array_key_exists($lang->name, $custom)) $code = $custom[$lang->name];

      $codes[$lang->id] = $code;
      $string .= "$lang->name=$code<br>";
    }
    if($returnString) return $string;
    return $codes;
  }

  /**
   * pull translation files from modules to language
   */
  public function pull() {
    foreach($this->getLanguageCodes() as $id=>$code) {
      // find all language files in site modules
      $modules = $this->wire->config->paths->siteModules;
      $files = glob($modules."*/RockLanguage/$code/site--modules--*.json");
      foreach($files as $moduleFile) {
        $name = basename($moduleFile);
        $langFile = $this->wire->config->paths->files.$id."/$name";
        $this->copyIfNewer($moduleFile, $langFile, "language $id");
      }
    }
  }

  /**
   * push translation files from language to modules
   */
  public function push() {
    foreach($this->getLanguageCodes() as $id=>$code) {
      // find all language files in language folder
      $langpath = $this->wire->config->paths->files.$id."/";
      $files = glob($langpath."site--modules--*.json");
      foreach($files as $langFile) {
        $json = json_decode(file_get_contents($langFile));
        $parts = explode("/", $json->file);
        $module = $parts[2];
        $dir =
          $this->wire->config->paths->siteModules
          ."$module/RockLanguage/$code/";
        if(!is_dir($dir)) continue;
        $moduleFile = $dir.basename($langFile);
        $this->copyIfNewer($langFile, $moduleFile, "module $module");
      }
    }
  }

  /**
   * Sync language files
   */
  public function sync() {
    if(!$this->wire->user->isSuperuser()) return;
    if(!$this->wire->config->debug) return;
    $this->pull();
    $this->push();
  }

  /**
  * Config inputfields
  * @param InputfieldWrapper $inputfields
  */
  public function getModuleConfigInputfields($inputfields) {
    $inputfields->add([
      'type' => 'textarea',
      'name' => 'customCodes',
      'label' => 'Language Code Mapping Overrides',
      'notes' => 'Enter one per line, eg default=DE',
      'value' => $this->customCodes,
    ]);

    $inputfields->add([
      'type' => 'markup',
      'label' => 'Available Mappings',
      'value' => $this->getLanguageCodes(true),
      'notes' => 'This field lists all available languages and their folder names that will be used to push/pull translation files to.'
        ."\nA foldername **DE** means that translations will be synced to /site/modules/YourModule/RockLang/**DE**/yourfile.json",
    ]);

    return $inputfields;
  }

}
