import {ParserHeaderConfigInterface} from "../config/ParserConfig"
import {Axios} from "axios";
import {ProductSeriesDto} from "../dto/ProductSeriesDto";

export interface ProductSeriesItemInterface {
    seriesDescription: string
    seriesId: string
}

interface ProductSeriesInterface {
    get(dto: ProductSeriesDto): ProductSeriesItemInterface[];
}

export class ProductSeries implements ProductSeriesInterface {

    static apiMethod = '/equipment/series';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    // @ts-ignore
    async get(dto: ProductSeriesDto): Promise<ProductSeriesItemInterface[]> {

        let url = this.parserConfig.apiUrl + ProductSeries.apiMethod;

        const urlRequest = new URL(url);
        urlRequest.searchParams.append("productTypeId", dto.productTypeId);
        urlRequest.searchParams.append("productLineId", dto.productLineId);

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
