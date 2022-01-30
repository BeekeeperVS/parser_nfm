import {ParserHeaderConfigInterface} from "../config/ParserConfig"
import {Axios} from "axios";
import {AssemblyDto} from "../dto/AssemblyDto";

export class AssembliesItemInterface {
    assemblyCode: string;
    assemblyId: string;
    assemblyName: string;
    hasNote: boolean;
    image: string;
}


interface AssemblyGroupInterface {
    get(dto: AssemblyDto): Promise<AssembliesItemInterface[]>;
}

export class Assemblies implements AssemblyGroupInterface{

    static apiMethod = '/models/assembliesByFunctionalGroup';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }
    async get(dto: AssemblyDto): Promise<AssembliesItemInterface[]> {

        let url = this.parserConfig.apiUrl + Assemblies.apiMethod;

        const urlRequest = new URL(url);
        urlRequest.searchParams.append("modelId", dto.modelId);
        urlRequest.searchParams.append("functionalGroupId", dto.functionalGroupId);
        urlRequest.searchParams.append("isTechnicalTypeDriven", String(dto.isTechnicalTypeDriven));
        urlRequest.searchParams.append("imageType", dto.imageType);
        urlRequest.searchParams.append("filterForSN", String(dto.filterForSN));


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