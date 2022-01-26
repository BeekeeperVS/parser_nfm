import {ParserHeaderConfigInterface} from "../config/ParserConfig"
import {Axios} from "axios";
import {ProductTypeDto} from "../dto/ProductTypeDto";

export interface ProductTypeItemInterface {
    productTypeDescription: string
    productTypeId: string
}

interface ProductTypesInterface {
    apiMethod: string;

    get(dto: ProductTypeDto): ProductTypeItemInterface[];
}

export class ProductTypes implements ProductTypesInterface {

    static apiMethod = '/equipment/productTypes';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    // @ts-ignore
    async get(dto: ProductTypeDto): Promise<ProductTypesInterface[]> {

        let url = this.parserConfig.apiUrl + ProductTypes.apiMethod;

        let axios = new Axios({
            headers: {
                userId: this.parserConfig.header.userId,
                language: this.parserConfig.header.language,
                regionId: this.parserConfig.header.regionId,
                brandId: dto.brandId,
            }
        });
        let response = await axios.get(url);
        return JSON.parse(response.data);
    }
}