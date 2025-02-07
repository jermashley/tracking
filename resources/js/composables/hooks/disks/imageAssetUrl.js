import { usePage } from '@inertiajs/vue3'

const imageAssetUrl = ({ filePath = null } = {}) => {
  const { spaces } = usePage().props.app.disks

  return `https://${spaces.bucket}.${spaces.region}.cdn.digitaloceanspaces.com/${filePath}`
}

export default imageAssetUrl
