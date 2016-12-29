'use strict';

const yeomanBase = require('yeoman-generator').Base;

module.exports = yeomanBase.extend({
  constructor: function constructor() {
    yeomanBase.apply(this, arguments);
  },

  prompting: function prompting() {
    this.log('welcome again');
  }
});
