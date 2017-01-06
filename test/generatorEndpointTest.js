'use strict';

const path = require('path');
const assert = require('yeoman-assert');
const helpers = require('yeoman-test');
const endpointName = 'ritchie';

require('chai').should();

describe('endpointName generator', () => {
  before((done) => {
    helpers.run(path.join(__dirname, '../generators/endpoint'))
      .withPrompts({ endpoint: endpointName })
      .withOptions({ skipInstall: true, force: true })
      .on('end', done);
  });

  it('creates files', () => {
    assert.file([
      'src/controllers/' + endpointName + '/index.php',
      'src/controllers/' + endpointName +
      '/' + endpointName + 'Controller.php'
    ]);
  });

  it('replaces the placeholders in index and controller', () => {
    let indexPath = 'src/controllers/' + endpointName + '/index.php';
    let controllerPath = 'src/controllers/' + endpointName +
      '/' + endpointName + 'Controller.php';

    assert.noFileContent(indexPath, /{endpointname}/);
    assert.fileContent(indexPath, endpointName);

    assert.noFileContent(controllerPath, /{endpointname}/);
    assert.fileContent(controllerPath, endpointName);
  });
});
