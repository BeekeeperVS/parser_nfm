import {ParserHeaderConfigInterface} from "../config/ParserConfig"
import {Axios} from "axios";
import {BrandsDto} from "../dto/BrandsDto";

export interface BrandsItemInterface {
    brandName: string[],
}

interface BrandsInterface {
    get(dto: BrandsDto): BrandsItemInterface[];
}

export class Brands implements BrandsInterface {

    static apiMethod = '/categoriesapi';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    // @ts-ignore
    async get(dto: BrandsDto): Promise<BrandsItemInterface[]> {
        let url = this.parserConfig.apiUrl + Brands.apiMethod;
        let axios = new Axios({
            headers: {
                Authorization: "Bearer "+dto.bearerToken,
                'Accept-Language': this.parserConfig.header.language
            }
        });
        let response = await axios.get(url);
        return JSON.parse(response.data);
    }
}