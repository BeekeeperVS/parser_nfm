import {ParserHeaderConfigInterface} from "../config/ParserConfig"
import {Axios} from "axios";
import {SchemesDto} from "../dto/SchemesDto";

interface BrandsInterface {
    get(dto: SchemesDto): any;
}

export class Schemes implements BrandsInterface {

    static apiMethod = '/booktoc';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    // @ts-ignore
    async get(dto: SchemesDto): any {
        let url = this.parserConfig.apiUrl + Schemes.apiMethod + "/" + dto.brandTitle + "/" + dto.modelId + "/l/All";
        const urlRequest = new URL(url);
        urlRequest.searchParams.append("tocGuid", String(dto.tocGuid));

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