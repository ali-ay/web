import fs from 'fs';
import path from 'path';

const getfolders = dir =>
  fs.readdirSync(dir).filter(file => fs.statSync(path.join(dir, file)).isDirectory());

export default getfolders;
