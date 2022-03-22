import {ConfigService} from "@nestjs/config";

interface HeaderOptionInterface {
    language: string
}

export interface ParserHeaderConfigInterface {
    header: HeaderOptionInterface;
    catalogUrl: string,
    apiUrl: string,
    loginUrl: string,
    login: string,
    password: string
}

export const parserConfig = ((): ParserHeaderConfigInterface => ({
    header: {
        language: 'ru'
    },
    catalogUrl: process.env.AGCONET_EPSILON1_URL,
    apiUrl: process.env.AGCONET_API_URL,
    loginUrl: process.env.AGCONET_LOGIN_URL,
    login: process.env.AGCONET_LOGIN,
    password: process.env.AGCONET_PASSWORD
}));
