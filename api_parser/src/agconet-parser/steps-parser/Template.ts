import {ParserHeaderConfigInterface} from "../config/ParserConfig"
import {Axios} from "axios";

export interface TemplateItemInterface {
    brandId: number,
    brandName: string,
    brandCode: string
}

interface TemplateInterface {
    get(dto: any): TemplateItemInterface[];
}

export class Template implements TemplateInterface {

    static apiMethod = '/brands';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    // @ts-ignore
    async get(dto: any): Promise<TemplateItemInterface[]> {

        return ;//JSON.parse();
    }
}