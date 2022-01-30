import {ParserHeaderConfigInterface} from "../config/ParserConfig";
import {Axios} from "axios";
import {AssemblyDetailsDto} from "../dto/AsseblyDetailsDto";

interface AssemblyHotspots {
    active: boolean;//false
    assemblyFullName: string;//"0.312.0[05] - CAMSHAFT AND DRIVE-GEARING "
    assemblyId: string;//"B2C020B1-B8BF-E111-9FCE-005056875BD6"
    calloutinfo_x1_y1: string;//"1647,3046"
    calloutinfo_x2_y2: string;//"1647,3121"
    calloutinfo_x3_y3: string;//"1721,3121"
    calloutinfo_x4_y4: string;//"1721,3046"
    referenceAssemblyFullName?: string;//null
    referenceAssemblyId: string;//""
    referenceNumber: string;//"3"
}

interface AssemblyDetailsInterface {
    assemblyCode: string;//"0.312.0[05]"
    assemblyDescription: string;//"CAMSHAFT AND DRIVE-GEARING"
    assemblyFullName: string;//"0.312.0[05] - CAMSHAFT AND DRIVE-GEARING "
    assemblyId: string;//"B2C020B1-B8BF-E111-9FCE-005056875BD6"
    assemblyImage: string;//"UklGRsgWAQBXRUJQVlA4TLsWAQAvc8uFA/+gqG0baK+e/BF3I
    functionalGroupCode: string;//"01"
    functionalGroupDescription: string;//"ENGINE"
    functionalGroupId: string;//"22F9724F-E6BE-E111-9FCE-005056875BD6_01_ENGINE"
    hotspots: AssemblyHotspots[]
}


export class AssemblyDetails {

    static apiMethod = '/assemblies/details';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }
    async get(dto: AssemblyDetailsDto): Promise<AssemblyDetailsInterface> {

        let url = this.parserConfig.apiUrl + AssemblyDetails.apiMethod;

        const urlRequest = new URL(url);
        urlRequest.searchParams.append("modelId", dto.modelId);
        urlRequest.searchParams.append("assemblyId", dto.assemblyId);
        urlRequest.searchParams.append("imageType", String(dto.imageType));
        urlRequest.searchParams.append("isTechnicalTypeDriven", String(dto.isTechnicalTypeDriven));
        urlRequest.searchParams.append("serialNumberId", String(dto.serialNumberId));


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