// 一覧取得: GET /api/microcms/:endpoint?orders=...&limit=...
export default defineEventHandler(async (event) => {
  const endpoint = assertEndpoint(getRouterParam(event, 'endpoint'))
  const queries = pickQueries(getQuery(event))

  try {
    return await getMicroCMSClient().get({ endpoint, queries })
  } catch (error) {
    throw toMicroCMSError(error)
  }
})
