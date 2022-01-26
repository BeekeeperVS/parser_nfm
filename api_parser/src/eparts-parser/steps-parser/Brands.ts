import {ParserHeaderConfigInterface} from "../config/ParserConfig"
import {Axios} from "axios";
import {BrandDto} from "../dto/BrandDto";

export interface BrandItemInterface {
    brandId: number,
    brandName: string,
    brandCode: string
}

interface BrandsInterface {
    get(dto: BrandDto): BrandItemInterface[];
}

export class Brands implements BrandsInterface {

    static apiMethod = '/brands';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    // @ts-ignore
    async get(dto: BrandDto): Promise<BrandItemInterface[]> {
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