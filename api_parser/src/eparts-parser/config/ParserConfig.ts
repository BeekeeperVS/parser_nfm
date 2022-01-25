import {ConfigService} from "@nestjs/config";

interface HeaderOptionInterface {
    userId: string,
    language: string,
    regionId: number,
}

export interface ParserHeaderConfigInterface {
    header: HeaderOptionInterface;
    apiUrl: string
}

export const parserConfig = ((): ParserHeaderConfigInterface => ({
    header: {
        userId: process.env.EPARSER_API_USERID,
        language: 'en',
        regionId: 3,
    },
    apiUrl: process.env.EPARSER_API_URL
}));
