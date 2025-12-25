import yaml from 'yamljs';
import fs from 'fs';

export const CONFIG_PATH = `${__dirname}/../../app/config/config_prod.yml`;

const getConfig = () => yaml.parse(fs.readFileSync(CONFIG_PATH, 'utf-8'));

export default getConfig;
