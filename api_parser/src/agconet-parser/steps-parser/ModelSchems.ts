import {ParserHeaderConfigInterface} from "../config/ParserConfig"
import {Axios} from "axios";
import {ModelSchemesDto} from "../dto/ModelSchemesDto";

interface BrandsInterface {
    get(dto: ModelSchemesDto): any;
}

export class ModelSchemes implements BrandsInterface {

    static apiMethod = '/PageTOCLocation';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    // @ts-ignore
    async get(dto: ModelSchemesDto): any {
        let url = this.parserConfig.apiUrl + ModelSchemes.apiMethod + "/" + dto.brandTitle + "/" + dto.modelId + "/l/00-toc";
        const urlRequest = new URL(url);

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