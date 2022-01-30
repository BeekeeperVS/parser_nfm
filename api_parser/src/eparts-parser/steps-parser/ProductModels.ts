import {ParserHeaderConfigInterface} from "../config/ParserConfig"
import {Axios} from "axios";
import {ProductModelDto} from "../dto/ProductModelDto";

export interface ProductModelsItemInterface {
    modelId: string;
    isTechnicalTypeDriven: boolean;
    prodStartDate: string;
    prodEndDate: string;
    modelNumber: string;
    modelDescription: string;
}

interface ProductModelsInterface {
    get(dto: ProductModelDto): ProductModelsItemInterface[];
}

export class ProductModels implements ProductModelsInterface {

    static apiMethod = '/equipment/models';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    // @ts-ignore
    async get(dto: ProductModelDto): Promise<ProductModelsItemInterface[]> {

        let url = this.parserConfig.apiUrl + ProductModels.apiMethod;

        const urlRequest = new URL(url);
        urlRequest.searchParams.append("productTypeId", dto.productTypeId);
        urlRequest.searchParams.append("productLineId", dto.productLineId);
        urlRequest.searchParams.append("seriesId", dto.seriesId);

        let axios = new Axios({
            headers: {
                userId: this.parserConfig.header.userId,
                language: this.parserConfig.header.language,
                regionId: this.parserConfig.header.regionId,
                brandId: dto.brandId,
            }
        });

        let response = await axios.get(urlRequest.href);
        return JSON.parse(response.data);
    }
}
