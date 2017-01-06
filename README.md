# generator-elitecareer-api
## What is this?
generator-elitecareer-api is a PHP Rest API generator. It is designed to create new PHP Rest API, having complete configuration.

## Development

1. Any files starting with _ in the templates have placeholder values in them.

## Install the generator

1. Make sure you have [yo](https://github.com/yeoman/yo) installed:
     `npm install -g yo`

2. Install the module globally from npm:

   ```
   npm install -g generator-elitecareer-api
   ```

## Create a new EliteCareer Api Project using the generator

1. Create a directory for your project in this formate
  ```
  apiname.env.elitecareer.net
  ```

2. From that directory, run
  ```
  yo elitecareer-api
  ```

3. You will be prompted for the project name and option for creating endpoint.

At this point you will have a working project with an endpoint if you selected that option. After you confirm that the project is runnable, remove configuration and other information that is not appropriate for your endpoints.


## Add additional endpoints to your project after the initial generation

1. From your projects folder, enter:
  ```
  yo elitecareer-api:endpoint
  ```
  Note that the exact string `endpoint` option should be used. You will enter your custom names in the next step.

2. When prompted, enter endpoint you wish to generate. The new endpoint you specify will be added to your project. Currently we are supporting only one endpoint creation at a time.

## Updating your projects and rerunning the generator

1. Make sure you are on a clean status git branch so you can use the power of
git to revert reset if you want.

2. From your projects folder, enter:
  ```
  yo elitecareer-api
  ```
3. You will be prompted again for your project name. Just enter the same name as it was before.

4. You can choose to overwrite all files and view the git diff or pick and choose
which files to overwrite.

*IMPORTANT*
If it's an existing project, you probably want to be careful when overwriting files. Especially `config/*` files
so you do not lose any existing settings.

After updating you will probably want to do a series of steps.

1. Manually update `config` since you probably didn't overwrite it.

2. Run test.
