import {ParserHeaderConfigInterface} from "../config/ParserConfig"
import {Axios} from "axios";
import {CategoryDto} from "../dto/CategoryDto";

interface BrandsInterface {
    get(dto: CategoryDto): any;
}

export class CatalogPats implements BrandsInterface {

    static apiMethod = '/categoriesapi';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    // @ts-ignore
    async get(dto: CategoryDto): any {
        let url = this.parserConfig.apiUrl + CatalogPats.apiMethod + "/" + dto.brandTitle;
        const urlRequest = new URL(url);
        urlRequest.searchParams.append("categoryId", String(dto.categoryId));
        let axios = new Axios({
            headers: {
                Authorization: "Bearer " + dto.bearerToken,
                'Accept-Language': this.parserConfig.header.language
            }
        });
        let response = await axios.get(urlRequest.href);
        return JSON.parse(response.data);
    }
}