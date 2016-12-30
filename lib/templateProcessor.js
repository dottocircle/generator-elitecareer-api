'use strict';

const path = require('path');
const walk = require('walk');

function processTemplates(generator, sourceRoot, destinationRoot, context, completecallback) {
  let walker = walk.walk(sourceRoot, { followLinks: false });
  let fileHandler = function fileHandler(root, fileStats, next) {
    let rootFilePath = path.resolve(root, fileStats.name);
    let relativeFilePath = path.relative(sourceRoot, rootFilePath);
    let destinationFilePath = path.join(destinationRoot, relativeFilePath);

    generator.fs.copyTpl(
      rootFilePath, destinationFilePath, context
    );

    next();
  };

  let endHandler = function endHandler() {
    if (completecallback) { completecallback(); }
  };

  walker.on('file', fileHandler);
  walker.on('end', endHandler);
}

module.exports = {
  processTemplates: processTemplates
};

