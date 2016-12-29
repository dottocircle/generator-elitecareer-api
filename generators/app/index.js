'use strict';

const yeoman = require('yeoman-generator');
const chalk = require('chalk');
const yosay = require('yosay');

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
  },

  writing: {
    app: function app() {
      this.log('app writing');
    }
  },

  install: function install() {
    this.log('install');
  },

  end: function end() {
    this.log('end');
  }
});
