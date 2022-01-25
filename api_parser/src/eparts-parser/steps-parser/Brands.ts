import {ParserHeaderConfigInterface} from "../config/ParserConfig"
import {Axios} from "axios";

export interface BrandItemInterface {
    brandId: number,
    brandName: string,
    brandCode: string
}

interface BrandsInterface {
    get(): BrandItemInterface[];
}

export class Brands implements BrandsInterface {

    static apiMethod = '/brands';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }


    // @ts-ignore
    async get(): Promise<BrandItemInterface[]> {
        let url = this.parserConfig.apiUrl + Brands.apiMethod;
        let userId = this.parserConfig.header.userId;
        let axios = new Axios({
            headers: {
                userId: this.parserConfig.header.userId,
                language: this.parserConfig.header.language,
                regionId: this.parserConfig.header.regionId,
            }
        });
        let response = await axios.get(url);
        return JSON.parse(response.data);
    }
}