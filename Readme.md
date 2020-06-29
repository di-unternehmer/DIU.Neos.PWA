# Service Worker (PWA) for Neos
This packages adds a basic configuration to precache content using service worker with google workbox.

## Setup
Run `composer require diu/neos-serviceworker`

### Configuration
Copy the following files to your site package and change the values to your need:

  - `Settings.Manifest.yaml`
  - `Settings.Workbox.yaml` For all configuration options see: https://developers.google.com/web/tools/workbox
  - `Settings.MsApplication.yaml` 

Add all icons for the manifest, an example is in the `Settings.Manfiest.yaml` and set name, colors ...
  
For the workbox setting, it is usually enough to adapt only the globPattern to your needs. 
We recommand to only include files from your package, don't add any Neos static files. 

All necessary configurations are added to the `Neos.Neos:Page` prototype.
The initialisation of the service worker is done via inline javascript before the closing body tag. 

SUGGESTION:
Exclude in your .gitignore `/Web/sw.js` and `/Web/workbox-*` as they get automatically generated and versioned by workbox-cli

### Local testing
We recommend to use DDEV as you need a valid https connection, but it should also work with `http://localhost` for development.

 - make sure you have installed the package
 - Run `./flow pwa:create`
 - Run `yarn add workbox-cli && npx workbox-cli generateSW`
 (instead of yarn you can also use `npm install workbox-cli`) 
 

### Add to your CI/CD pipeline
Add these build steps:

  - `./flow pwa:create` This will create the workbox-config.json in your project root
  - `yarn add workbox-cli && npx workbox-cli generateSW` This will generate your service worker, based on the workbox-config.js in your `/Web` directory 
  
(instead of yarn you can also use `npm install workbox-cli`) 


## Roadmap
If somehow possible generate workbox-config.json on composer install, based on the provided Settings.Workbox.yaml
