import {ParserHeaderConfigInterface} from "../config/ParserConfig";
import {Axios} from "axios";
import {PartSubstitutionsDto} from "../dto/PartSubstitutions";

interface SubstitutionItemInterface {
    backwardSubstitution: number;//0
    condtionalNotes: any;//null
    isInWorkingList: number;//0
    partDescription: string;//"CAMSHAFT"
    partIdFrom: string;//"83995389"
    partIdTo: string;//"87802906"
    subQty: number;//1
    substitutionCode: string;//"2"
    substitutionIndicator: number;//1
    substitutionType: string;//"F"
    technicalDescription: string;//" "
}


export class PartsSubstitutions {

    static apiMethod = '/parts/substitutions';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    async get(dto: PartSubstitutionsDto): Promise<SubstitutionItemInterface[]> {

        let url = this.parserConfig.apiUrl + PartsSubstitutions.apiMethod;

        const urlRequest = new URL(url);
        urlRequest.searchParams.append("partId", String(dto.partId));


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