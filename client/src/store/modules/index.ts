const requireModule = require.context('.', true, /\.ts$/);
const modules: { [key: string]: any } = {};

requireModule.keys().forEach((filename) => {
    // Ignore current file
    if (filename === './index.ts') {
        return;
    }

    const filenameWithoutDirectory = filename.split('./')[1];
    let filenameWithoutExtension = filenameWithoutDirectory.split('.')[0];
    filenameWithoutExtension = filenameWithoutExtension.toLocaleLowerCase();

    modules[filenameWithoutExtension] = requireModule(filename).default;
});

export default modules;
