import {ParserHeaderConfigInterface} from "../config/ParserConfig";
import {Axios} from "axios";
import {AssemblyPartsDto} from "../dto/AssemblyPartsDto";

interface NavigationAssembliesInterface {
    assemblyCode: string;//"0.120.5[01]"
    assemblyFullName: string;//"0.120.5[01] - ELECTRONIC CONTROL UNIT / SENSOR "
    assemblyId: string;//"4BC120B1-B8BF-E111-9FCE-005056875BD6"
}

interface ParsAssemblyInterface {
    alternativeIndicator: boolean;//false
    assemblyId: string;//"B2C020B1-B8BF-E111-9FCE-005056875BD6"
    assemblyPartListId: string;//"7132EE64-5DC4-E111-9FCE-005056875BD6_B2C020B1-B8BF-E111-9FCE-005056875BD6_G01_87802906"
    componentIndicator: boolean;//true
    image: string;//"/9j/2wBDAAMCAgMCAgMDAwMEAwMEBQgFBQQEBQoHBwYIDAoMD
    isInWorkingList: boolean;//false
    kitIndicator: boolean;//false
    notes: boolean;//false
    partDescription: string;//"GEAR"
    partId: string;//"87802906"
    partNumber: string;//"87802906"
    quantity: string;//"1"
    referenceNumber: string;//"2"
    remanIndicator: false
    sequence_number: string;//495760
    skuGlobal: string;//"87802906"
    substitutionCode: string;//"0"
    substitutionIndicator: true
    substitutionType: string;//"P"
    technicalDescription: string;//" "
    technicalImage: boolean;//false
    usage: string;//""
}

interface AssemblyPartsInterface {
    navigation: NavigationAssembliesInterface[];
    parts: ParsAssemblyInterface[];
}


export class AssemblyParts {

    static apiMethod = '/parts/byAssembly';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    async get(dto: AssemblyPartsDto): Promise<AssemblyPartsInterface> {

        let url = this.parserConfig.apiUrl + AssemblyParts.apiMethod;

        const urlRequest = new URL(url);
        urlRequest.searchParams.append("assemblyId", dto.assemblyId);
        urlRequest.searchParams.append("serialNumberId", String(dto.serialNumberId));
        urlRequest.searchParams.append("imageType", String(dto.imageType));
        urlRequest.searchParams.append("isTechnicalTypeDriven", String(dto.isTechnicalTypeDriven));
        urlRequest.searchParams.append("filterForSN", String(dto.filterForSN));
        urlRequest.searchParams.append("functionalGroupId", String(dto.functionalGroupId));


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