import {ParserHeaderConfigInterface} from "../config/ParserConfig"
import {Axios} from "axios";

export interface ProductLinesItemInterface {
    ProductLinesDescription: string
    ProductLinesId: string
}

interface ProductLinesInterface {
    get(): ProductLinesItemInterface[];
}

export class ProductLines implements ProductLinesInterface {

    static apiMethod = '/equipment/productLines';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    // @ts-ignore
    async get(productTypeId: string): Promise<ProductLinesItemInterface[]> {

        let url = this.parserConfig.apiUrl + ProductLines.apiMethod;

        const urlRequest = new URL(url);
        urlRequest.searchParams.append("productTypeId", productTypeId);

        let axios = new Axios({
            headers: {
                userId: this.parserConfig.header.userId,
                language: this.parserConfig.header.language,
                regionId: this.parserConfig.header.regionId,
                brandId: 2,
            }
        });

        let response = await axios.get(urlRequest.href);
        return JSON.parse(response.data);
    }
}


