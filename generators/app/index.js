'use strict';

const yeoman = require('yeoman-generator');
const chalk = require('chalk');
const yosay = require('yosay');
const templateProcessor = require('../../lib/templateProcessor');


module.exports = yeoman.extend({
  constructor: function constructor() {
    yeoman.apply(this, arguments);
    this.log(this.sourceRoot());
    this.log(this.destinationRoot());
  },

  prompting: function prompting() {
    this.log(yosay(
      `welcome to ${chalk.red('EliteCareerApi')} generator!`
    ));

    let appName = this.appname.split(' ');
    appName = appName.join('.');

    let prompts = [
      {
        type: 'input',
        name: 'packageName',
        message: 'what is your app name?',
        default: appName
      },
      {
        type: 'confirm',
        name: 'dummyEndpoint',
        message: 'would you like to start an endpoint?',
        default: false
      }
    ];

    return this.prompt(prompts).then(function prompt(context) {
      this.context = context;
    }.bind(this));
  },

  writing: {
    app: function app() {
      let done = this.async();
      let sourceRoot = this.sourceRoot();
      let destinationRoot = this.destinationRoot();
      this.log(this.context);
      this.log('app writing');

      templateProcessor.processTemplates(this,
        sourceRoot, destinationRoot, this.context, done);
    },

    endpoints: function endpoints() {
      if (this.context.dummyEndpoint) {
        this.composeWith('elitecareer-api:endpoint', {});
      }
    }
  },

  install: function install() {
    this.log('install');
  },

  end: function end() {
    this.log('end');
  }
});
