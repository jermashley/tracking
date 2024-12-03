import axios from 'axios'

const createCompany = async (formData) => {
  const { data } = await axios.post(route(`api.companies.store`), formData)

  return data
}
