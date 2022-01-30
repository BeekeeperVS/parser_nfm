import {ParserHeaderConfigInterface} from "../config/ParserConfig";
import {Axios} from "axios";
import {PartKitsDto} from "../dto/PartKitsDto";

interface KitItemInterface {
    applyForThisModel: boolean;//false
    isInWorkingList: boolean;//false
    partDescription: string;//"KIT"
    partId: string;//"84227819KIT"
    skuGlobal: string;//"84227819KIT"
    technicalDescription: string;//" "
}


export class PartKits {

    static apiMethod = '/parts/kits';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    async get(dto: PartKitsDto): Promise<KitItemInterface[]> {

        let url = this.parserConfig.apiUrl + PartKits.apiMethod;

        const urlRequest = new URL(url);
        urlRequest.searchParams.append("partId", String(dto.partId));
        urlRequest.searchParams.append("modelId", String(dto.modelId));


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