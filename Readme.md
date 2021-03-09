# Service Worker (PWA) for Neos
This package adds a basic configuration to precache content using service worker with google workbox.
Furthermore, it will add a "Add to homescreen" for your devices who are supporting it.

## Setup
Run `composer require diu/neos-pwa`

### Configuration
Copy the following files to your site package and change the values to your need:

  - `Settings.Manifest.yaml`
  - `Settings.Workbox.yaml` For all configuration options see: https://developers.google.com/web/tools/workbox
  - `Settings.MsApplication.yaml` 

Add all icons for the manifest, an example is in the `Settings.Manfiest.yaml` and set name, colors ...
  
For the workbox setting, it is usually enough to adapt only the globPattern to your needs. 
We recommend to only include files from your package, don't add any Neos static files. 

All necessary configurations are added to the `Neos.Neos:Page` prototype.
The initialisation of the service worker is done via inline javascript before the closing body tag. 

SUGGESTION:
Exclude in your .gitignore `/Web/sw.js` and `/Web/workbox-*` as they should be automatically generated
while your CI/CD process and is versioned by workbox-cli.

### Create workbox-config.js
Run `./flow pwa:create` or `./flow pwa:update`.
This will create/update the workbox-config.json in your project root.

### Local testing
We recommend to use DDEV as you need a valid https connection, but it should also work with `http://localhost` for development.

 - make sure you have installed the package
 - Run `npm add workbox-cli && npx workbox generateSW`
 (instead of yarn you can also use `yarn install workbox-cli`) 
 

### Add to your CI/CD pipeline
Add these build steps:

  - Run `./flow resource:publish --collection static` as workbox needs the static files while building the service worker in next step
  - `npm add workbox-cli && npx workbox-cli generateSW` This will generate your service worker, based on the workbox-config.js in your `/Web` directory 
  
(instead of yarn you can also use `yarn install workbox-cli`) 


## Roadmap
1. Autogenerate all favicon/icons based on Manifest.yaml and add them to the header

## Sponsor
This Neos plugin is kindly sponsored by DI Unternehmer - Digitalagentur GmbH
