export default {
  SET_COUNTER: (state, { type, counter }) => {
    state.counters[type] = counter
  },
  ADD_SECTION: (state, name) => {
    state.quotes.section[name] = name
  },
  SET_TOTAL: (state, totals) => {
    state.totals.expense = totals
  }
}
