'use strict';

const yeoman = require('yeoman-generator');
const templateProcessor = require('../../lib/templateProcessor');

module.exports = yeoman.extend({
  constructor: function constructor() {
    yeoman.apply(this, arguments);
  },

  prompting: function prompting() {
    let prompts = [
      {
        type: 'input',
        name: 'endpoint',
        message: 'Name for your endpoint + controller?',
        default: 'dummy'
      }
    ];

    return this.prompt(prompts).then(function prompt(context) {
      this.context = context;
    }.bind(this));
  },

  writing: {
    endpoint: function endpoint() {
      let self = this;
      let done = self.async();

      self.log('in endpoint generator writing');

      let sourceRoot = self.sourceRoot();
      let destinationRoot = self.destinationRoot();

      if (self.context.endpoint) {
        self.log(`generating ${self.context.endpoint}`);
        let context = { endpointname: self.context.endpoint };

        templateProcessor
          .processTemplates(
            self,
            sourceRoot,
            destinationRoot,
            context, done);
      }
    }
  }
});
