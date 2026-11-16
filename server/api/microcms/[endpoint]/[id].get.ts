// 詳細取得: GET /api/microcms/:endpoint/:id
export default defineEventHandler(async (event) => {
  const endpoint = assertEndpoint(getRouterParam(event, 'endpoint'))
  const contentId = getRouterParam(event, 'id')
  const queries = pickQueries(getQuery(event))

  if (!contentId) {
    throw createError({ statusCode: 404, statusMessage: 'Not Found' })
  }

  try {
    return await getMicroCMSClient().get({ endpoint, contentId, queries })
  } catch (error) {
    throw toMicroCMSError(error)
  }
})
