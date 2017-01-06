'use strict';

const path = require('path');
const assert = require('yeoman-assert');
const helpers = require('yeoman-test');
const expectedAppName = 'apiname.qa.elitecareer.net';

require('chai').should();

describe('app generator', () => {
  before((done) => {
    let deps = [
        [helpers.createDummyGenerator(), 'elitecareer.net:endpoint']
    ];

    helpers.run(path.join(__dirname, '../generators/app'))
      .withGenerators(deps)
      // force overwrite of templates in case of conflicts
      .withOptions({ skipInstall: true, force: true })
      .withPrompts({ someOption: true })
      .on('end', done);
  });

  it('creates files', () => {
    assert.file([
      '.htaccess',
      'index.html'
    ]);
  });

  it('replaces the placeholders in index.html', () => {
    assert.noFileContent('index.html', /{endpointname}/);
    assert.fileContent('index.html', expectedAppName);
  });
});
