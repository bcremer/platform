import ApiService from './api.service';

/**
 * Gateway for the API end point "media"
 * @class
 * @extends ApiService
 */
class MediaApiService extends ApiService {
    constructor(httpClient, loginService, apiEndpoint = 'media') {
        super(httpClient, loginService, apiEndpoint);
    }
}

export default MediaApiService;
