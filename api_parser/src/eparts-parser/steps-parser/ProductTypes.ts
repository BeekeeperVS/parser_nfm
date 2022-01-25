import {ParserHeaderConfigInterface} from "../config/ParserConfig"
import {Axios} from "axios";

export interface ProductTypeItemInterface {
    productTypeDescription: string
    productTypeId: string
}

interface ProductTypesInterface {
    apiMethod: string;

    get(): ProductTypeItemInterface[];
}

export class ProductTypes implements ProductTypesInterface {

    static apiMethod = '/equipment/productTypes';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    // @ts-ignore
    async get(): Promise<ProductTypesInterface[]> {

        let url = this.parserConfig.apiUrl + ProductTypes.apiMethod;

        let axios = new Axios({
            headers: {
                userId: this.parserConfig.header.userId,
                language: this.parserConfig.header.language,
                regionId: this.parserConfig.header.regionId,
                brandId: 2,
            }
        });
        let response = await axios.get(url);
        return JSON.parse(response.data);
    }
}