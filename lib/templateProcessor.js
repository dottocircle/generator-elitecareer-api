'use strict';

const path = require('path');
const walk = require('walk');

function processPathPlaceholder(destinationFilePath, context) {
  let finalPathArray = [];
  let pathArray = destinationFilePath.split('/');
  pathArray.forEach(function (part) {
    if (part.includes('{')) {
      finalPathArray.push(part.replace(/[{].*[}]/, context.endpointname));
    } else {
      finalPathArray.push(part);
    }
  });

  return finalPathArray.join('/');
}

function processTemplates(generator, sourceRoot, destinationRoot, context, completecallback) {
  let walker = walk.walk(sourceRoot, { followLinks: false });
  let fileHandler = function fileHandler(root, fileStats, next) {
    let rootFilePath = path.resolve(root, fileStats.name);
    let fileName = path.basename(rootFilePath);
    if (fileName[0] === '_') {
      fileName = fileName.substring(1);
    }

    let updatedRootFilePath = path.resolve(root, fileName);


    let relativeFilePath = path.relative(sourceRoot, updatedRootFilePath);

    let destinationFilePath = path.join(destinationRoot, relativeFilePath);

    generator.log(path.basename(destinationFilePath));

    destinationFilePath = processPathPlaceholder(destinationFilePath, context);
    generator.log('after', destinationFilePath);

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

