<?php
namespace Neni\PhptalBundle\Translation;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;

/**
 * Description of TranslationService
 *
 * @author tarjei (based on the example found in PHPTAL. )
 */
class SymfonyTranslationService implements \PHPTAL_TranslationService{

    private $translator;
    private $domain = 'messages';
    private $vars = array();
    public function __construct($translator = null) {
      $this->translator = $translator;
    }

    public function setTranslator($translator) {
      $this->translator = $translator;
    }
    /**
     * Set the target language for translations.
     *
     * When set to '' no translation will be done.
     *
     * You can specify a list of possible language for exemple :
     *
     * setLanguage('fr_FR', 'fr_FR@euro')
     *
     * @return string - chosen language
     */
    function setLanguage(/**/) {
        $langs = func_get_args();
        if (count($langs))
        foreach($langs as $locale) {
          $this->translator->setLocale($locale);
        }
      
    }

    /**
     * PHPTAL will inform translation service what encoding page uses.
     * Output of translate() must be in this encoding.
     */
    function setEncoding($encoding) {
      if ($encoding != 'UTF-8') {
        throw new \Exception("Only UTF-8 supported!");
      }

    }

    /**
     * Set the domain to use for translations (if different parts of application are translated in different files. This is not for language selection).
     */
    function useDomain($domain) {
      $this->domain = $domain;
      return $this->domain;
    }


    /**
     * Set XHTML-escaped value of a variable used in translation key.
     *
     * You should use it to replace all ${key}s with values in translated strings.
     *
     * @param string $key - name of the variable
     * @param string $value_escaped - XHTML markup
     */
    function setVar($key, $value_escaped) {
      $this->vars[$key] = $value_escaped;
    }
    function getVar($key) {
      return $this->vars[$key];
    }

    /**
     * Translate a gettext key and interpolate variables.
     *
     * @param string $key - translation key, e.g. "hello ${username}!"
     * @param string $htmlescape - if true, you should HTML-escape translated string. You should never HTML-escape interpolated variables.
     */
    function translate($key, $htmlescape=true) {
        $value = $this->translator->trans($key, array(), $this->domain);
        if ($htmlescape) {
            $value = htmlspecialchars($value, ENT_QUOTES);
        }
        while (preg_match('/\${(.*?)\}/sm', $value, $m)) {
            list($src, $var) = $m;
            if (!array_key_exists($var, $this->vars)) {
                throw new \PHPTAL_VariableNotFoundException('Interpolation error. Translation uses ${'.$var.'}, which is not defined in the template (via i18n:name)');
            }
            $value = str_replace($src, $this->vars[$var], $value);
        }
        return $value;
    }

}
?>
