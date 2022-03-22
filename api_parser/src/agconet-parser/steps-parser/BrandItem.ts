import {ParserHeaderConfigInterface} from "../config/ParserConfig"
import {Axios} from "axios";
import {BrandItemDto} from "../dto/BrandItemDto";

interface BrandsInterface {
    get(dto: BrandItemDto): any;
}

export class BrandItem implements BrandsInterface {

    static apiMethod = '/categoriesapi';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    // @ts-ignore
    async get(dto: BrandItemDto): any {
        let url = this.parserConfig.apiUrl + BrandItem.apiMethod + "/" + dto.brandTitle;
        let axios = new Axios({
            headers: {
                Authorization: "Bearer " + dto.bearerToken,
                // 'Accept-Language': this.parserConfig.header.language
            }
        });
        let response = await axios.get(url);
        return JSON.parse(response.data);
    }
}