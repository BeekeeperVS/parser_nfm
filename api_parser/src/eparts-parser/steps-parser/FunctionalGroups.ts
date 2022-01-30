import {ParserHeaderConfigInterface} from "../config/ParserConfig"
import {Axios} from "axios";
import {FunctionalGroupDto} from "../dto/FunctionalGroupDto";

export interface FunctionalGroupsItemInterface {
    functionalGroupCode: string;//"00"
    functionalGroupDescription: string;//"COMPLETE MACHINE"
    functionalGroupId: string;//"B2F6724F-E6BE-E111-9FCE-005056875BD6_00_COMPLETE_MACHINE"
}

interface FunctionalGroupsInterface {
    get(dto: FunctionalGroupDto): FunctionalGroupsItemInterface[];
}

export class FunctionalGroups implements FunctionalGroupsInterface {

    static apiMethod = '/models/functionalGroups';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    // @ts-ignore
    async get(dto: FunctionalGroupDto): Promise<FunctionalGroupsInterface[]> {

        let url = this.parserConfig.apiUrl + FunctionalGroups.apiMethod;

        const urlRequest = new URL(url);
        urlRequest.searchParams.append("modelId", dto.modelId);

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