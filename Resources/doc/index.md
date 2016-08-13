Getting Started With Tag Library
================================

## Installation and usage

Installation and usage is a quick:

1. Install Library using composer
2. Basic usage the library
3. Usage tag manager
4. Usage with symfony [form](http://symfony.com/doc/current/components/form/introduction.html)


### Step 1: Install library using composer

Tell composer to download the bundle by running the command:

``` bash
$ composer require fdevs/tag
```

Composer will install the library to your project's `vendor/fdevs` directory.


### Step 2: Basic usage the library

```php
<?php
require __DIR__.'/../vendor/autoload.php';

use FDevs\Locale\Model\LocaleText;
use FDevs\Tag\Model\Tag;

$symfony = new Tag();

$symfony
    ->addName(new LocaleText('Symfony', 'en'))
    ->setSlug('symfony')
    ->setType('frameworks');

$article = new Article();
$article->addTag($symfony);
```

### Step 3: Usage tag manager
 
#### add [doctrine mongodb](http://docs.doctrine-project.org/projects/doctrine-mongodb-odm/en/latest/index.html):

```php

<?php
require __DIR__.'/../vendor/autoload.php';

use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\SimplifiedXmlDriver;
use FDevs\Locale\Model\LocaleText;
use FDevs\Tag\Doctrine\TagManager;
use Symfony\Component\EventDispatcher\EventDispatcher;

$config = new Configuration();
//....
$refl = new \ReflectionClass('FDevs\Tag\TagInterface');
$mappings = ['FDevs\Tag\Model' => realpath(dirname($refl->getFileName()).'/Resources/doctrine/model')];
$driver = new SimplifiedXmlDriver($mappings, 'mongodb.xml');
$config->setMetadataDriverImpl($driver);

$dm = DocumentManager::create(new Connection(), $config);
$dispatcher = new EventDispatcher();

$manager = new TagManager($dm,'FDevs\Tag\Model\Tag',$dispatcher);
// The same text in different languages
$symfony = $manager->createTag();
$symfony
    ->addName(new LocaleText('Symfony', 'en'))
    ->setSlug('symfony')
    ->setType('frameworks');

//....
$article = new Article();
$article->addTag($symfony);
```

####Use with symfony [event manager](http://symfony.com/doc/current/components/event_dispatcher/introduction.html):
```php
use FDevs\Tag\Events;
use FDevs\Tag\Event\TagEvent;

$dispatcher->addListener(Events::TAG_CREATE, function(TagEvent $event){

});
$dispatcher->addListener(Events::TAG_PRE_REMOVE, function(TagEvent $event){

});
$dispatcher->addListener(Events::TAG_POST_REMOVE, function(TagEvent $event){

});
$dispatcher->addListener(Events::TAG_POST_PERSIST, function(TagEvent $event){

});
$dispatcher->addListener(Events::TAG_PRE_PERSIST, function(TagEvent $event){

});
```

### Step 4: Usage with symfony form

```php
<?php

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Form\Forms;
use FDevs\Tag\Form\Type\TagType;
use FDevs\Locale\Form\Type\TransType;
use FDevs\Locale\Form\Type\TransTextType;
use FDevs\Locale\Form\Type\LocaleType;
use FDevs\Locale\Form\Type\LocaleTextType;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Translator;


// the Twig file that holds all the default markup for rendering forms
// this file comes with TwigBridge

// the path to TwigBridge so Twig can locate the
// form_div_layout.html.twig file
$defaultFormTheme = 'form_div_layout.html.twig';
$ref = new ReflectionClass('Symfony\Bridge\Twig\TwigEngine');
$vendorTwigBridgeDir = dirname($ref->getFileName());

$tagTypes = ['frameworks', 'js'];
// the path to your other templates
$twig = new \Twig_Environment(new \Twig_Loader_Filesystem([$vendorTwigBridgeDir.'/Resources/views/Form']));

$formEngine = new TwigRendererEngine([$defaultFormTheme]);
$formEngine->setEnvironment($twig);
// add the FormExtension to Twig
$twig->addExtension(new FormExtension(new TwigRenderer($formEngine)));
$twig->addExtension(new TranslationExtension(new Translator('en')));
$transForm = new TransType();
$transForm->setLocales(['en', 'ru']);
$formFactory = Forms::createFormFactoryBuilder()
    ->addExtension(new ValidatorExtension(Validation::createValidator()))
    ->addTypes([
//add locale form
        new LocaleType(),
        new LocaleTextType(),
        $transForm,
        new TransTextType(),

        new TagType($tagTypes),
    ])
    ->getFormFactory();


$form = $formFactory->createBuilder()
    ->add('tag', TagType::class)
    ->getForm();

echo $twig->createTemplate('{{form(form)}}')->render(['form' => $form->createView()]);
```
