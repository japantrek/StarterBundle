# StarterBundle
Symfony CMF  bundle for easy start

## Requirements

* Symfony 2.3.x
* Symfony CMF

## Documentation

### Installation

[Install Symfony CMF standart edition](http://symfony.com/doc/master/cmf/book/installation.html)

Add the package to your composer.json file
```
"nvbooster/starter-bundle": "dev-master",
```

Add bundles to app/AppKernel.php

**Note**: set NvboosterStarterBundle before CmfBlockBundle

```php
<?php
    public function registerBundles()
    {
        $bundles = array(
            ...
              new nvbooster\StarterBundle\NvboosterStarterBundle(),
              new Symfony\Cmf\Bundle\BlockBundle\CmfBlockBundle(),
            ...  
              new Symfony\Cmf\Bundle\CreateBundle\CmfCreateBundle(),
              new Symfony\Cmf\Bundle\MediaBundle\CmfMediaBundle(),
              new Burgov\Bundle\KeyValueFormBundle\BurgovKeyValueFormBundle(),
              new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
              new FM\ElfinderBundle\FMElfinderBundle(),
              new Liip\ImagineBundle\LiipImagineBundle(),
              new Sonata\AdminBundle\SonataAdminBundle(),
              new Sonata\jQueryBundle\SonatajQueryBundle(),
              new Symfony\Cmf\Bundle\TreeBrowserBundle\CmfTreeBrowserBundle(),
              new Sonata\DoctrinePHPCRAdminBundle\SonataDoctrinePHPCRAdminBundle(),                            
        );
        ...
        return $bundles;
    }
```

Include routes to app/config/routing.yml

```
starter_routing:
    resource: "@NvboosterStarterBundle/Resources/config/routing/routing.xml"
    prefix:   /
    
starter_external:
    resource: "@NvboosterStarterBundle/Resources/config/routing/external.xml"
    prefix:   /
```

### Configuration

```
nvbooster_starter:
    wrap_urls: true    #if true externalcontent twig filter will redirect all url links to external link landing page 
    templates:
        externallink:  #extarnal link landing page template
```        
        
in app/config/parameters.yml set host_whitelist with array of hosts.
external links to wgitlisted hosts will not show landing page and redirect directly to the url address 

```
host_whitelist:
        - myhost.com
```

## See also:

* [Symfony CMF standard edition documentation](http://symfony.com/doc/master/cmf/book/installation.html)
* [All Symfony CMF documentation](http://symfony.com/doc/master/cmf/index.html) - complete Symfony CMF reference
* [Symfony CMF Website](http://cmf.symfony.com/) - introduction, live demo, support and community links