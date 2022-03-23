import {ParserHeaderConfigInterface} from "../config/ParserConfig"
import {Axios} from "axios";
import {SchemeDetailDto} from "../dto/SchemeDetailDto";

interface BrandsInterface {
    get(dto: SchemeDetail): any;
}

export class SchemeDetail implements BrandsInterface {

    static apiMethod = '/PagesAPIViewer';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    // @ts-ignore
    async get(dto: SchemeDetailDto): any {
        let url = this.parserConfig.apiUrl + SchemeDetail.apiMethod + "/" + dto.brandTitle + "/" + dto.modelId + "/l/"+dto.schemeId;
        const urlRequest = new URL(url);
        urlRequest.searchParams.append("img", "0");
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