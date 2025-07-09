import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const setLogo = async (companyId, imageId, type) => {
  const { data } = await axios.patch(
    route(`api.companies.setImageAsset`, companyId),
    {
      image_id: imageId,
      type: type,
    },
  )

  return data
}

const usePermissionSetImageAssetMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ companyId = null, imageId = null, type = null }) =>
      setLogo(companyId, imageId, type),

    ...config,
  })

export default usePermissionSetImageAssetMutation
